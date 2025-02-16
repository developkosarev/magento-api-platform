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
    public const USER_ID = 1;
    public const USER_TEST = 'test@example.com';
    public const USER_PLAIN_PASSWORD = 'Password@2022';
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
        $item = $this->mCustomerRepository->findOneBy(['email' => self::USER_TEST]);
        if (null === $item) {
            $item = new Customer();
            $item->setId(self::USER_ID);
        }

        $item->setWebsiteId(1);
        $item->setEmail(self::USER_TEST);
        $item->setGroupId(1);
        $item->setStoreId(1);
        $item->setFirstName(self::USER_FIRSTNAME);
        $item->setLastName(self::USER_LASTNAME);
        $item->setCreatedIn('Germany');
        $item->setPasswordHash(self::USER_PASSWORD_HASH);
        $item->setRpToken(self::USER_PASSWORD_RP_TOKEN);
        $item->setDefaultBilling(1);
        $item->setDefaultShipping(1);

        $this->magentoEntityManager->persist($item);
        $this->magentoEntityManager->flush();

        $this->addReference(self::CUSTOMER_1_REFERENCE, $item);
    }

    public static function getGroups(): array
    {
        return ['magento'];
    }
}
