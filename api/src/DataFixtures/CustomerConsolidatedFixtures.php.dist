<?php

namespace App\DataFixtures;

use App\Entity\Main\CustomerConsolidated;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\Ulid;

class CustomerConsolidatedFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 3; $i++) {
            $customer = new CustomerConsolidated();
            $customer->setEmail('customer' . $i . '@example.com');
            $manager->persist($customer);
        }

        $manager->flush();
    }
}
