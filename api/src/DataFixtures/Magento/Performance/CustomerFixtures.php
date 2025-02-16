<?php

namespace App\DataFixtures\Magento\Performance;

use App\Entity\Magento\Customer;
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
    public const CUSTOMER_COUNT = 50000;

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

        $batchSize = 1000;

        for ($i = 1; $i <= self::CUSTOMER_COUNT; $i++) {
            if (($i % $batchSize) === 0) {
                $this->magentoEntityManager->flush();
                $this->magentoEntityManager->clear();

                $progressBar->advance($batchSize);
            }

            $item = new Customer();
            $item->setWebsiteId(1);
            $item->setEmail('test' . $i . '@example.com');
            $item->setGroupId(1);
            $item->setStoreId(1);
            $item->setFirstName(self::USER_FIRSTNAME);
            $item->setLastName(self::USER_LASTNAME);
            $item->setCreatedIn('Germany');
            $item->setPasswordHash(self::USER_PASSWORD_HASH);
            $item->setRpToken(self::USER_PASSWORD_RP_TOKEN);

            $this->magentoEntityManager->persist($item);
        }
        $this->magentoEntityManager->flush();

        $progressBar->finish();

        echo PHP_EOL;
    }

    public static function getGroups(): array
    {
        return ['magento-performance'];
    }
}
