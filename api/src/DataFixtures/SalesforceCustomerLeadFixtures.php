<?php

namespace App\DataFixtures;

use App\Entity\Main\SalesforceCustomerLead;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SalesforceCustomerLeadFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 100; $i++) {
            $lead = new SalesforceCustomerLead();
            $lead
                ->setEmail('customer' . $i . '@example.com')
                ->setCustomerId($i);

            $manager->persist($lead);
        }

        $manager->flush();
    }
}
