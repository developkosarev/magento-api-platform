<?php

namespace App\Service\Bloomreach\Customer;

use App\Entity\Magento\Customer;
use App\Entity\Magento\CustomerSegment;
use App\Entity\Magento\CustomerSegmentWebsite;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Console\Output\OutputInterface;

class CustomerSegmentImport implements CustomerSegmentImportInterface
{
    private const INSERT_BATCH_SIZE = 5000;

    private int $segmentId;
    private int $websiteId;
    private bool $force;
    private int $limit = self::INSERT_BATCH_SIZE;
    private array $customerHashTable;
    private ?OutputInterface $output = null;
    private EntityRepository $mCustomerRepository;
    private EntityRepository $mCustomerSegmentRepository;
    private EntityRepository $mCustomerSegmentWebsiteRepository;

    public function __construct(
        private readonly CsvReader $csvReader,
        private readonly EntityManagerInterface $magentoEntityManager
    ) {
        $this->mCustomerRepository = $this->magentoEntityManager->getRepository(Customer::class);
        $this->mCustomerSegmentRepository = $this->magentoEntityManager->getRepository(CustomerSegment::class);
        $this->mCustomerSegmentWebsiteRepository = $this->magentoEntityManager->getRepository(CustomerSegmentWebsite::class);
    }

    /**
     * @throws \Exception
     */
    public function execute(int $segmentId, int $websiteId, string $fileName): void
    {
        if (!file_exists($fileName)) {
            throw new \Exception("File of segments \"{$fileName}\" not found!");
        }

        $segment = $this->mCustomerSegmentRepository->find($segmentId);
        if ($segment === null) {
            throw new \Exception("Segment \"{$segmentId}\" not found!");
        }
        $this->segmentId = $segmentId;

        $segmentWebsite = $this->mCustomerSegmentWebsiteRepository->findOneBy(['segment' => $segmentId, 'website' => $websiteId]);
        if ($segmentWebsite === null) {
            throw new \Exception("Website \"{$websiteId}\" not found!");
        }
        $this->websiteId = $websiteId;

        $emails = [];
        $segments = [];

        $i = 0;
        foreach ($this->csvReader->read($fileName) as $row) {
            $email = $row[0];
            $segmentValue = $row[1];

            $emails[] = $email;
            $segments[] = ['email' => $email, 'segment_value' => $segmentValue];

            $i++;
            if (($i % $this->limit) === 0) {
                $this->populateCustomerHashTable($websiteId, $emails);
                $this->createBatchInsert($segments);

                $emails = [];
                $segments = [];

                if ($this->output !== null) {
                    $msg = "<info>Count </info>#{$i}<info> Memory: {$this->getMemoryUsage()}MB</info>";
                    $this->output->writeln($msg);
                }
            }
        }

        if (!empty($emails)) {
            $this->populateCustomerHashTable($websiteId, $emails);
            $this->createBatchInsert($segments);
        }

        if ($this->output !== null) {
            $msg = "<info>Count </info>#{$i}<info> Memory: {$this->getMemoryUsage()}MB</info>";
            $this->output->writeln($msg);
        }

        $this->force = false;
    }

    public function setForce(bool $force): void
    {
        $this->force = $force;
    }

    public function setOutput(OutputInterface $output): void
    {
        $this->output = $output;
    }

    public function setLimit(int $limit): void
    {
        if ($limit > 0) {
            $this->limit = $limit;
        }
    }

    private function getMemoryUsage(): float
    {
        $memUsage = memory_get_usage(true);
        return round($memUsage / 1048576, 2);
    }

    private function createBatchInsert(array $segments): void
    {
        $values = [];
        $params = [];

        $i = 0;
        foreach ($segments as $segment) {
            $email = $segment['email'];
            $segmentValue = $segment['segment_value'];

            if (isset($this->customerHashTable[$email])) {
                $customer = $this->customerHashTable[$email];
            } else {
                continue;
            }

            $i++;

            $values[] = "(:segment_id_{$i}, :customer_id_{$i}, :website_id_{$i}, NOW(), NOW(), :segment_value_{$i})";

            $params["segment_id_{$i}"] = $this->segmentId;
            $params["customer_id_{$i}"] = $customer->getId();
            $params["website_id_{$i}"] = $this->websiteId;
            $params["segment_value_{$i}"] = $segmentValue;
        }

        if (!empty($params)) {
            $this->executeBatchInsert($values, $params);
        }
    }

    private function executeBatchInsert(array $values, array $params): void
    {
        $connection = $this->magentoEntityManager->getConnection();
        $sql = "INSERT INTO sunday_customersegment_customer (segment_id, customer_id, website_id, created_at, updated_at, segment_value)
                VALUES " . implode(', ', $values) .
                " ON DUPLICATE KEY UPDATE updated_at = NOW(), segment_value = VALUES(segment_value)";

        if ($this->force) {
            $stmt = $connection->prepare($sql);
            $stmt->executeStatement($params);
        }
    }

    private function populateCustomerHashTable(int $websiteId, array $emails): void
    {
        $this->customerHashTable = [];

        $customers = $this->mCustomerRepository->getCustomersByEmail($websiteId, $emails);
        foreach ($customers as $customer) {
            $this->customerHashTable[$customer->getEmail()] = $customer;
        }
        $this->magentoEntityManager->clear();
    }
}
