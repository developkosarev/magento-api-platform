<?php

namespace App\DataFixtures\Magento;

use App\Entity\Magento\CustomerSegment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class CustomerSegmentFixtures extends Fixture implements FixtureGroupInterface
{
    private ManagerRegistry $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    public function load(ObjectManager $manager): void
    {
        $magentoManager = $this->managerRegistry->getManager('magento');

        $item = new CustomerSegment();
        $item->setName('segment1');
        $item->setIsActive(true);
        $magentoManager->persist($item);

        $magentoManager->flush();
    }

    public static function getGroups(): array
    {
        return ['magento'];
    }
}
