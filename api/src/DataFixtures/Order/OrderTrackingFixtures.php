<?php

namespace App\DataFixtures\Order;

use App\Entity\Main\Order\Tracking;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OrderTrackingFixtures extends Fixture
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
}
