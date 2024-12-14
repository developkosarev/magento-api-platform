<?php

namespace App\Tests\Service\Salesforce;

use App\Service\Salesforce\Customer\LeadCustomerSerializer;
use App\Service\Salesforce\Dto\CustomerLeadDto;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class LeadCustomerSerializerTest extends KernelTestCase
{
    private const EMAIL = 'test@test.test';
    private const FIRSTNAME = 'FirstName';
    private const LASTNAME = 'LastName';
    private const BIRTHDAY = '2000-01-01';

    private static LeadCustomerSerializer $leadCustomerSerializer;

    public static function setUpBeforeClass(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        self::$leadCustomerSerializer = $container->get(LeadCustomerSerializer::class);
    }

    public function testLeadCustomerSerialize()
    {
        $result = self::$leadCustomerSerializer->normalize($this->createLeadCustomer());

        $body = [
            'CustomerID' => 1,
            'Email' => self::EMAIL,
            'FirstName' => self::FIRSTNAME,
            'LastName' => self::LASTNAME,
            'Birthday' => self::BIRTHDAY,
            'Specialties' => 1871,
            'Street' => 'Kurfürstendamm',
            'PostalCode' => '10000',
            'City' => 'Berlin',
            'Country' => 'DE',
        ];

        $this->assertEquals($body, $result);
    }

    public function testLeadCompanySerialize()
    {
        $result = self::$leadCustomerSerializer->normalize($this->createLeadCompany());

        $body = [
            'CustomerID' => 1,
            'Email' => self::EMAIL,
            'FirstName' => self::FIRSTNAME,
            'LastName' => self::LASTNAME,
            'Birthday' => self::BIRTHDAY,
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

    private function createLeadCustomer(): CustomerLeadDto
    {
        return new CustomerLeadDto(
            1,
            self::EMAIL,
            self::FIRSTNAME,
            self::LASTNAME,
            \DateTime::createFromFormat('Y-m-d', self::BIRTHDAY),
            1871,
            'Kurfürstendamm',
            '10000',
            'Berlin',
            'DE',
            null,
            null,
            null,
        );
    }

    private function createLeadCompany(): CustomerLeadDto
    {
        return new CustomerLeadDto(
            1,
            self::EMAIL,
            'FirstName',
            'LastName',
            \DateTime::createFromFormat('Y-m-d', self::BIRTHDAY),
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
