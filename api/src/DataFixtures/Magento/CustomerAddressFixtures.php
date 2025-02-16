<?php

namespace App\DataFixtures\Magento;

use App\Entity\Magento\CustomerAddress;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\ORM\Mapping\ClassMetadata;

class CustomerAddressFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    public const CUSTOMER_ADDRESS_ID = 1;
    public const USER_FIRSTNAME = 'Test';
    public const USER_LASTNAME = 'Test';
    private EntityRepository $mCustomerAddressesRepository;

    public function __construct(
        private readonly EntityManagerInterface $magentoEntityManager
    ) {
        $this->mCustomerAddressesRepository = $this->magentoEntityManager->getRepository(CustomerAddress::class);
        $this->magentoEntityManager
            ->getClassMetadata(CustomerAddress::class)
            ->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
    }

    public function load(ObjectManager $manager): void
    {
        $item = $this->mCustomerAddressesRepository->find(self::CUSTOMER_ADDRESS_ID);
        if (null === $item) {
            $item = new CustomerAddress();
            $item->setId(self::CUSTOMER_ADDRESS_ID);
        }

        $item->setParentId(CustomerFixtures::USER_ID);
        $item->setCity('Berlin');
        $item->setCountryId('DE');
        $item->setStreet('Franz' . PHP_EOL . '3');
        $item->setRegionId(0);
        $item->setPostcode('10000');
        $item->setTelephone('');
        $item->setFirstName(self::USER_FIRSTNAME);
        $item->setLastName(self::USER_LASTNAME);

        $this->magentoEntityManager->persist($item);
        $this->magentoEntityManager->flush();
    }

    public static function getGroups(): array
    {
        return ['magento'];
    }

    public function getDependencies(): array
    {
        return [CustomerFixtures::class];
    }
}
