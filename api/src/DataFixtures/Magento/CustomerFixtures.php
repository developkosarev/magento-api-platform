<?php

namespace App\DataFixtures\Magento;

use App\Entity\Magento\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class CustomerFixtures extends Fixture implements FixtureGroupInterface
{
    public const USER_TEST = 'test@example.com';
    public const USER_PLAIN_PASSWORD = 'password@test';

    private EntityRepository $mCustomerRepository;

    public function __construct(
        private readonly EntityManagerInterface $magentoEntityManager
    ) {
        $this->mCustomerRepository = $this->magentoEntityManager->getRepository(Customer::class);
    }

    public function load(ObjectManager $manager): void
    {
        //$item = $this->mCustomerRepository->findOneBy(['email' => self::FIXTURE_USER_TEST]);
        //if (null === $item) {
        //    $item = new Customer();
        //    echo 'Exist';
        //}

        //$item->setWebsiteId(1);
        //$item->setEmail(self::FIXTURE_USER_TEST);
        //$item->setGroupId(1);
        //$item->setStoreId(1);
        //$item->setIsActive(true);

        //$this->magentoEntityManager->persist($item);
        //$this->magentoEntityManager->flush();
    }

    public static function getGroups(): array
    {
        return ['magento'];
    }
}
