<?php

namespace App\Tests\Service\Salesforce;

use App\Entity\Main\SalesforceCustomerLead;
use App\Service\Salesforce\Customer\LeadCustomerSerializer;
use App\Service\Salesforce\Dto\CustomerLeadDto;
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

        $body = [
            'CustomerID' => 1,
            'Email' => self::EMAIL,
            'FirstName' => 'FirstName',
            'LastName' => 'LastName',
            'Birthday' => '2000-01-01',
            'Specialties' => 1871,
            'Street' => 'Kurfürstendamm',
            'PostalCode' => '10000',
            'City' => 'Berlin',
            'Country' => 'DE',
            'Phone' => '1111111111',
            'Company' => 'Company',
            'VAT_Number' => '222222'
        ];

        $this->assertEquals($body, $result);
    }

    private function createLead()
    {
        return new CustomerLeadDto(
            1,
            self::EMAIL,
            'FirstName',
            'LastName',
            \DateTime::createFromFormat('Y-m-d', '2000-01-01'),
            1871,
            'Kurfürstendamm',
            '10000',
            'Berlin',
            'DE',
            '1111111111',
            'Company',
            '222222'
        );
    }
}
