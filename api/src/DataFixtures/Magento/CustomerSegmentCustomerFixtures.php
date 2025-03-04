<?php

namespace App\DataFixtures\Magento;

use App\Entity\Magento\CustomerSegmentCustomer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class CustomerSegmentCustomerFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    public function __construct(
        private readonly EntityManagerInterface $magentoEntityManager
    ) {}

    public function load(ObjectManager $manager): void
    {
        $item = new CustomerSegmentCustomer();

        $item->setSegment($this->getReference(CustomerSegmentFixtures::CUSTOMER_SEGMENT_1_REFERENCE));
        $item->setCustomer($this->getReference(CustomerFixtures::CUSTOMER_1_REFERENCE));
        $item->setWebsite($this->getReference(StoreWebsiteFixtures::WEBSITE_1_REFERENCE));
        $item->createdAt = new \DateTime();
        $item->updatedAt = new \DateTime();

        $this->magentoEntityManager->persist($item);
        $this->magentoEntityManager->flush();
    }

    public static function getGroups(): array
    {
        return ['magento'];
    }

    public function getDependencies(): array
    {
        return [StoreWebsiteFixtures::class, CustomerSegmentFixtures::class, CustomerFixtures::class];
    }
}
