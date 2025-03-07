<?php

namespace App\Service\Bloomreach\Customer;

use App\Entity\Magento\Customer;
use App\Entity\Magento\CustomerSegment;
use App\Entity\Magento\CustomerSegmentCustomer;
use App\Entity\Magento\CustomerSegmentWebsite;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Console\Output\OutputInterface;

class CustomerSegmentImport implements CustomerSegmentImportInterface
{
    private const INSERT_BATCH_SIZE = 50000;

    private bool $force;
    private array $customerHashTable;
    private ?OutputInterface $output = null;
    private EntityRepository $mCustomerRepository;
    private EntityRepository $mCustomerSegmentRepository;
    private EntityRepository $mCustomerSegmentWebsiteRepository;
    private EntityRepository $mCustomerSegmentCustomerRepository;

    public function __construct(
        private readonly CsvReader $csvReader,
        private readonly EntityManagerInterface $magentoEntityManager
    ) {
        $this->mCustomerRepository = $this->magentoEntityManager->getRepository(Customer::class);
        $this->mCustomerSegmentRepository = $this->magentoEntityManager->getRepository(CustomerSegment::class);
        $this->mCustomerSegmentWebsiteRepository = $this->magentoEntityManager->getRepository(CustomerSegmentWebsite::class);
        $this->mCustomerSegmentCustomerRepository = $this->magentoEntityManager->getRepository(CustomerSegmentCustomer::class);
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

        $segmentWebsite = $this->mCustomerSegmentWebsiteRepository->findOneBy(['segment' => $segmentId, 'website' => $websiteId]);
        if ($segmentWebsite === null) {
            throw new \Exception("Website \"{$websiteId}\" not found!");
        }

        $this->populateCustomerHashTable($websiteId);

        $values = [];
        $params = [];

        $i = 0;
        foreach ($this->csvReader->read($fileName) as $row) {
            $email = $row[0];
            $segmentValue = $row[1];

            $i++;
            if (($i % self::INSERT_BATCH_SIZE) === 0) {
                $this->magentoEntityManager->clear();

                if ($this->output !== null) {
                    $msg = "<info>Count </info>#{$i}<info> Memory: {$this->getMemoryUsage()}MB</info>";
                    $this->output->writeln($msg);
                }
            }

            if (isset($this->customerHashTable[$email])) {
                $customer = $this->customerHashTable[$email];
            } else {
                continue;
            }

            if ($this->force) {
                $values[] = "(:segment_id_{$i}, :customer_id_{$i}, :website_id_{$i}, NOW(), NOW(), :segment_value_{$i})";

                $params["segment_id_{$i}"] = $segmentId;
                $params["customer_id_{$i}"] = $customer['entity_id'];
                $params["website_id_{$i}"] = $websiteId;
                $params["segment_value_{$i}"] = $segmentValue;

                if (($i % self::INSERT_BATCH_SIZE) === 0) {
                    $this->executeBatchInsert($values, $params);
                    $values = [];
                    $params = [];
                }
            }
        }

        if ($this->force && !empty($values)) {
            $this->executeBatchInsert($values, $params);
        }
        $this->magentoEntityManager->clear();

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

    private function getMemoryUsage(): float
    {
        $memUsage = memory_get_usage(true);
        return round($memUsage / 1048576, 2);
    }

    private function executeBatchInsert(array $values, array $params): void
    {
        $connection = $this->magentoEntityManager->getConnection();
        $sql = "INSERT INTO sunday_customersegment_customer (segment_id, customer_id, website_id, created_at, updated_at, segment_value)
                VALUES " . implode(', ', $values) .
                " ON DUPLICATE KEY UPDATE updated_at = NOW(), segment_value = VALUES(segment_value)";

        $stmt = $connection->prepare($sql);
        $stmt->executeStatement($params);
    }

    private function populateCustomerHashTable(int $websiteId): void
    {
        $connection = $this->magentoEntityManager->getConnection();
        $selectQuery = $connection->executeQuery($this->getCustomersQuery(), ['website_id' => $websiteId]);
        $customers = $selectQuery->fetchAllAssociative();

        $this->customerHashTable = [];
        foreach ($customers as $row) {
            $this->customerHashTable[$row['email']] = $row;
        }

        if ($this->output !== null) {
            $msg = "<info>Customers hash table. Memory: {$this->getMemoryUsage()}MB</info>";
            $this->output->writeln($msg);
        }
    }

    private function getCustomersQuery(): string
    {
        return <<<SQL
            SELECT entity_id, email FROM customer_entity WHERE website_id = :website_id AND confirmation IS NULL;
        SQL;
    }
}
