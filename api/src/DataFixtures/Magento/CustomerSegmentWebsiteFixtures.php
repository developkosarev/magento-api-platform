<?php

namespace App\DataFixtures\Magento;

use App\Entity\Magento\CustomerSegmentWebsite;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class CustomerSegmentWebsiteFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    public function __construct(
        private readonly EntityManagerInterface $magentoEntityManager
    ) {}

    public function load(ObjectManager $manager): void
    {
        foreach ($this->getSegments() as [$reference]) {
            $item = new CustomerSegmentWebsite();
            $item->setSegment($this->getReference($reference));
            $item->setWebsite($this->getReference(StoreWebsiteFixtures::WEBSITE_1_REFERENCE));

            $this->magentoEntityManager->persist($item);
        }
        $this->magentoEntityManager->flush();
    }

    private function getSegments(): array
    {
        return [
            [CustomerSegmentFixtures::CUSTOMER_SEGMENT_1_REFERENCE],
            [CustomerSegmentFixtures::CUSTOMER_SEGMENT_99_REFERENCE],
        ];
    }

    public static function getGroups(): array
    {
        return ['magento'];
    }

    public function getDependencies(): array
    {
        return [StoreWebsiteFixtures::class, CustomerSegmentFixtures::class];
    }
}
