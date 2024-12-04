<?php

namespace App\DataFixtures;

use App\Entity\Main\SalesforceCustomerLead;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SalesforceCustomerLeadFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i < 3; $i++) {
            $lead = new SalesforceCustomerLead();
            $lead
                ->setLeadStatus(SalesforceCustomerLead::LEAD_STATUS_NEW)
                ->setStatus(SalesforceCustomerLead::STATUS_PROCESSED)
                ->setEmail('customer' . $i . '@example.com')
                ->setWebsiteId(1)
                ->setCustomerId($i)
                ->setFirstName('FirstName' . $i)
                ->setLastName('LastName' . $i)
                ->setCity('Berlin')
                ->setCountryId('DE')
                ->setStreet('Kurfürstendamm')
                ->setHouseNumber($i)
                ->setPostcode('10000')
                ->setLeadId('00Q9V00000KTZdBUAX');

            $manager->persist($lead);
        }

        $manager->flush();
    }
}
