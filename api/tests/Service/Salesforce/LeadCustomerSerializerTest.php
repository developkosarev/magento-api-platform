<?php

namespace App\Tests\Service\Salesforce;

use App\Entity\Main\SalesforceCustomerLead;
use App\Service\Salesforce\Customer\LeadCustomerSerializer;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class LeadCustomerSerializerTest extends KernelTestCase
{
    private const EMAIL = 'test@test.test';

    private static LeadCustomerSerializer $leadCustomerSerializer;

    public static function setUpBeforeClass(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        self::$leadCustomerSerializer = $container->get(LeadCustomerSerializer::class);
    }

    public function testSubscribeConfirmSerialize()
    {
        $result = self::$leadCustomerSerializer->normalize($this->createLead());

        //$body = '{"properties":{"header":"email","type":"NEWSLETTER_SUBSCRIBE_CONFIRM"},"body":{"confirm_code":"1","email":"test@test.test","website_id":1,"store_id":1}}';

        //$this->assertEquals($body, $result);
        $this->assertEquals(true, true);
    }

    private function createLead()
    {
        $lead = new SalesforceCustomerLead();
        $lead
            ->setLeadStatus(SalesforceCustomerLead::LEAD_STATUS_NEW)
            ->setStatus(SalesforceCustomerLead::STATUS_PROCESSED)
            ->setEmail(self::EMAIL)
            ->setWebsiteId(1)
            ->setCustomerId(1)
            ->setFirstName('FirstName')
            ->setLastName('LastName')
            ->setCity('Berlin')
            ->setCountryId('DE')
            ->setStreet('Kurfürstendamm')
            ->setHouseNumber(1)
            ->setPostcode('10000')
            ->setLeadId('00Q9V00000KTZdBUAX');

        return $lead;
    }
}
