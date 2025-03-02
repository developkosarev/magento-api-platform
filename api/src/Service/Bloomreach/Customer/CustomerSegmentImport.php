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
    private const INSERT_BATCH_SIZE = 10000;

    private bool $force;
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

        $connection = $this->magentoEntityManager->getConnection();

        $selectQuery = $connection->executeQuery($this->getCustomersQuery(), ['website_id' => $websiteId]);
        $customers = $selectQuery->fetchAllAssociative();

        $hashTable = [];
        foreach ($customers as $row) {
            $hashTable[$row['email']] = $row;
        }
        if ($this->output !== null) {
            $msg = "<info>Customers hash table. Memory: {$this->getMemoryUsage()}MB</info>";
            $this->output->writeln($msg);
        }

        $insertQuery = $connection->prepare($this->getInsertQuery());

        $values = [];
        $params = [];

        $i = 0;
        foreach ($this->csvReader->read($fileName) as $row) {
            $email = $row[0];

            $i++;
            if (($i % self::INSERT_BATCH_SIZE) === 0) {
                //if ($this->force) {
                //    $this->magentoEntityManager->flush();
                //}
                $this->magentoEntityManager->clear();

                //$segment = $this->mCustomerSegmentRepository->find($segmentId);
                //$segmentWebsite = $this->mCustomerSegmentWebsiteRepository->findOneBy(['segment' => $segmentId, 'website' => $websiteId]);
                if ($this->output !== null) {
                    $msg = "<info>Count </info>#{$i}<info> Memory: {$this->getMemoryUsage()}MB</info>";
                    $this->output->writeln($msg);
                }
            }

            //$customer = $this->mCustomerRepository->findOneBy(['email' => $email, 'websiteId' => $websiteId]);
            //if ($customer === null) {
            //    continue;
            //}

            if (isset($hashTable[$email])) {
                $customer = $hashTable[$email];
            } else {
                continue;
            }


            //$item = $this->mCustomerSegmentCustomerRepository->findOneBy([
            //    'segment' => $segment->getId(),
            //    'website' => $segmentWebsite->getWebsite(),
            //    'customer' => $customer->getId()
            //]);
            //
            //if ($item !== null) {
            //    continue;
            //}

            //$item = new CustomerSegmentCustomer();
            //$item
            //    ->setSegment($segment)
            //    ->setWebsite($segmentWebsite->getWebsite())
            //    ->setCustomer($customer);
            //$this->magentoEntityManager->persist($item);

            if ($this->force) {
                //$insertQuery->executeQuery([
                //    'segment_id' => $segmentId,
                //    'customer_id' => $customer['entity_id'], //$customer->getId(),
                //    'website_id' => $websiteId
                //]);


                $values[] = "(:segment_id_{$i}, :customer_id_{$i}, :website_id_{$i}, NOW(), NOW())";

                $params["segment_id_{$i}"] = $segmentId;
                $params["customer_id_{$i}"] = $customer['entity_id'];
                $params["website_id_{$i}"] = $websiteId;

                // Выполняем вставку каждые $batchSize записей
                if (($i % self::INSERT_BATCH_SIZE) === 0) {
                    $this->executeBatchInsert($values, $params);
                    $values = [];
                    $params = [];
                }
            }
        }

        if (!empty($values)) {
            $this->executeBatchInsert($values, $params);
        }

        //if ($this->force) {
        //    $this->magentoEntityManager->flush();
        //}
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

    private function getInsertQuery(): string
    {
        return <<<SQL
            INSERT INTO sunday_customersegment_customer (segment_id, customer_id, website_id, created_at, updated_at)
            VALUES (:segment_id, :customer_id, :website_id, NOW(), NOW())
            ON DUPLICATE KEY UPDATE
                updated_at = NOW();
        SQL;
    }

    private function executeBatchInsert(array $values, array $params): void
    {
        $connection = $this->magentoEntityManager->getConnection();
        $sql = "INSERT INTO sunday_customersegment_customer (segment_id, customer_id, website_id, created_at, updated_at) VALUES " . implode(', ', $values) . " ON DUPLICATE KEY UPDATE updated_at = NOW()";

        //echo $sql;

        $stmt = $connection->prepare($sql);
        $stmt->executeStatement($params);
    }

    private function getCustomersQuery(): string
    {
        return <<<SQL
            SELECT entity_id, email FROM customer_entity WHERE website_id = :website_id;
        SQL;
    }
}
