<?php

namespace App\DataFixtures\Magento\Performance;

use App\DataFixtures\Magento\CustomerSegmentFixtures;
use App\DataFixtures\Magento\StoreWebsiteFixtures;
use App\Entity\Magento\Customer;
use App\Entity\Magento\CustomerSegmentCustomer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class CustomerFixtures extends Fixture implements FixtureGroupInterface
{
    public const CUSTOMER_COUNT = 2000000;

    private const INSERT_BATCH_SIZE = 5000;

    public const USER_TEST = 'test@example.com';
    public const USER_PASSWORD_HASH = 'abf1de8d537a1270237b9b56c8db9c67aeece6d89639a64d5ffd7264262541ab:PNK7gwTSnTc9L8AXZEvgZQ4SA66qirus:3_32_2_67108864';
    public const USER_PASSWORD_RP_TOKEN = null;
    public const USER_FIRSTNAME = 'Test';
    public const USER_LASTNAME = 'Test';

    private EntityRepository $mCustomerRepository;

    public function __construct(
        private readonly EntityManagerInterface $magentoEntityManager
    ) {
        $this->mCustomerRepository = $this->magentoEntityManager->getRepository(Customer::class);
        $this->magentoEntityManager
            ->getClassMetadata(Customer::class)
            ->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
    }

    public function load(ObjectManager $manager): void
    {
        $output = new ConsoleOutput();
        $progressBar = new ProgressBar($output, self::CUSTOMER_COUNT);

        $values = [];
        $params = [];

        for ($i = 1; $i <= self::CUSTOMER_COUNT; $i++) {
            if (($i % self::INSERT_BATCH_SIZE) === 0) {
                //$this->magentoEntityManager->flush();
                //$this->magentoEntityManager->clear();

                $progressBar->advance(self::INSERT_BATCH_SIZE);
            }

            $email = 'test' . $i . '@example.com';

            //$item = new Customer();
            //$item->setWebsiteId(1);
            //$item->setEmail($email);
            //$item->setGroupId(1);
            //$item->setStoreId(1);
            //$item->setFirstName(self::USER_FIRSTNAME);
            //$item->setLastName(self::USER_LASTNAME);
            //$item->setCreatedIn('Germany');
            //$item->setPasswordHash(self::USER_PASSWORD_HASH);
            //$item->setRpToken(self::USER_PASSWORD_RP_TOKEN);

            //$this->magentoEntityManager->persist($item);

            //$itemSegment = new CustomerSegmentCustomer();
            //$itemSegment->setSegment($this->getReference(CustomerSegmentFixtures::CUSTOMER_SEGMENT_1_REFERENCE));
            //$itemSegment->setCustomer($item);
            //$itemSegment->setWebsite($this->getReference(StoreWebsiteFixtures::WEBSITE_1_REFERENCE));

            //$this->magentoEntityManager->persist($itemSegment);

            $values[] = "(:website_id_{$i}, :email_{$i}, :group_id_{$i}, :store_id_{$i}, :is_active_{$i}, :created_in_{$i}, :firstname_{$i}, :lastname_{$i}, :password_hash_{$i}, :rp_token_{$i})";

            $params["website_id_{$i}"] = 1;
            $params["email_{$i}"] = $email;
            $params["group_id_{$i}"] = 1;
            $params["store_id_{$i}"] = 1;
            $params["is_active_{$i}"] = 1;
            $params["created_in_{$i}"] = 'Germany';
            $params["firstname_{$i}"] = self::USER_FIRSTNAME;
            $params["lastname_{$i}"] = self::USER_LASTNAME;
            $params["password_hash_{$i}"] = self::USER_PASSWORD_HASH;
            $params["rp_token_{$i}"] = self::USER_PASSWORD_RP_TOKEN;

            if (($i % self::INSERT_BATCH_SIZE) === 0) {
                $this->executeCustomerBatchInsert($values, $params);
                $values = [];
                $params = [];
            }
        }
        if (!empty($values)) {
            $this->executeCustomerBatchInsert($values, $params);
        }
        //$this->magentoEntityManager->flush();

        $progressBar->finish();

        echo PHP_EOL;
    }

    private function executeCustomerBatchInsert(array $values, array $params): void
    {
        $connection = $this->magentoEntityManager->getConnection();
        $sql = "INSERT INTO customer_entity (website_id, email, group_id, store_id, is_active, created_in, firstname, lastname, password_hash, rp_token)
                VALUES " . implode(', ', $values);

        $stmt = $connection->prepare($sql);
        $stmt->executeStatement($params);
    }

    public static function getGroups(): array
    {
        return ['magento-performance'];
    }
}
