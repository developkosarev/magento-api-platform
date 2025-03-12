<?php

namespace App\DataFixtures\Magento;

use App\Entity\Magento\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\ORM\Mapping\ClassMetadata;

class CustomerFixtures extends Fixture implements FixtureGroupInterface
{
    public const CUSTOMER_1_REFERENCE = 'customer-1';
    public const CUSTOMER_2_REFERENCE = 'customer-2';
    public const CUSTOMER_3_REFERENCE = 'customer-3';
    public const CUSTOMER_4_REFERENCE = 'customer-4';

    private const WEBSITE_1_ID = 1;
    private const WEBSITE_2_ID = 2;

    private const STORE_1_ID = 1;
    private const STORE_16_ID = 16;

    public const USER_1_ID = 1;
    public const USER_2_ID = 2;
    public const USER_3_ID = 3;
    public const USER_4_ID = 4;

    private const USER_TEST = 'test@example.com';
    private const USER_2_TEST = 'test-2@example.com';
    private const USER_PLAIN_PASSWORD = 'Password@2022';
    private const USER_PASSWORD_HASH = 'abf1de8d537a1270237b9b56c8db9c67aeece6d89639a64d5ffd7264262541ab:PNK7gwTSnTc9L8AXZEvgZQ4SA66qirus:3_32_2_67108864';
    private const USER_PASSWORD_RP_TOKEN = null;
    private const USER_FIRSTNAME = 'Test';
    private const USER_LASTNAME = 'Test';

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
        foreach ($this->getCustomers() as [$id, $websiteId, $storeId, $email, $reference]) {
            $item = $this->mCustomerRepository->findOneBy(['email' => $email, 'websiteId' => $websiteId]);
            if (null === $item) {
                $item = new Customer();
                $item->setId($id);
            }

            $item->setWebsiteId($websiteId);
            $item->setEmail($email);
            $item->setGroupId(1);
            $item->setStoreId($storeId);
            $item->createdAt = new \DateTime();
            $item->updatedAt = new \DateTime();
            $item->setFirstName(self::USER_FIRSTNAME);
            $item->setLastName(self::USER_LASTNAME);
            $item->setCreatedIn('Germany');
            $item->setPasswordHash(self::USER_PASSWORD_HASH);
            $item->setRpToken(self::USER_PASSWORD_RP_TOKEN);
            $item->setDefaultBilling($id);
            $item->setDefaultShipping($id);

            $this->magentoEntityManager->persist($item);

            $this->addReference($reference, $item);
        }
        $this->magentoEntityManager->flush();
    }

    private function getCustomers(): array
    {
        return [
            [self::USER_1_ID, self::WEBSITE_1_ID, self::STORE_1_ID,  self::USER_TEST,   self::CUSTOMER_1_REFERENCE],
            [self::USER_2_ID, self::WEBSITE_1_ID, self::STORE_1_ID,  self::USER_2_TEST, self::CUSTOMER_2_REFERENCE],
            [self::USER_3_ID, self::WEBSITE_2_ID, self::STORE_16_ID, self::USER_TEST,   self::CUSTOMER_3_REFERENCE],
            [self::USER_4_ID, self::WEBSITE_2_ID, self::STORE_16_ID, self::USER_2_TEST, self::CUSTOMER_4_REFERENCE],
        ];
    }

    public static function getGroups(): array
    {
        return ['magento'];
    }
}
