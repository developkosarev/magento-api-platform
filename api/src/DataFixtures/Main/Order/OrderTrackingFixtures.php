<?php

namespace App\DataFixtures\Main\Order;

use App\Entity\Main\Order\Tracking;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class OrderTrackingFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 2; $i++) {
            $tracking = new Tracking();
            $tracking->setOrderNumber($i);
            $tracking->setStatus(Tracking::PENDING_STATUS);
            $manager->persist($tracking);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['main'];
    }
}
