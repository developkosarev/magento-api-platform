<?php

namespace App\Tests\Service\Salesforce;

use App\Entity\Main\SalesforceCustomerLead;
use App\Service\Salesforce\Common\Config;
use App\Service\Salesforce\Customer\LeadSenderService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class LeadSenderServiceTest extends KernelTestCase
{
    private const EMAIL = 'test@test.test';
    public static function setUpBeforeClass(): void
    {
        self::bootKernel();
        $container = static::getContainer();
    }

    public function testSendEmail()
    {
        //Symfony\Component\HttpClient\Response\TraceableResponse
        //$response = new Symfony\Component\HttpClient\Response\TraceableResponse();

        $config = $this->createMock(Config::class);
        $config->expects($this->any())
            ->method('getPrefix')
            ->willReturn('test');

        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->any())
            ->method('getStatusCode')
            ->willReturn(200);

        $response->expects($this->any())
            ->method('getContent')
            ->willReturn('[{"leadId":"00Q9V00000KTaSnUAL","type":"Lead creation","status":"success"}]');

        $httpClient = $this->createMock(HttpClientInterface::class);
        $httpClient->expects($this->any())
            ->method('request')
            ->willReturn($response);

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

        $leadSenderService = new LeadSenderService($httpClient, $config);
        $result = $leadSenderService->sendCustomer($lead, 'apiUrl', 'token');

        //"[{"leadId":"00Q9V00000KTaSnUAL","type":"Lead creation","status":"success"}]";
        //$content = '[{"leadId":"00Q9V00000KTaSnUAL","type":"Lead creation","status":"success"}]';
        //$data = json_decode($content, true);
        //var_dump($data);

        //var_dump($result);

        $this->assertIsArray($result);
        $this->assertEquals('00Q9V00000KTaSnUAL', $result[0]['leadId']);
        $this->assertEquals('success', $result[0]['status']);
    }
}
