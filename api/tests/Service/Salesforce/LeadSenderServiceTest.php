<?php

namespace App\Tests\Service\Salesforce;

use App\Entity\Main\SalesforceCustomerLead;
use App\Service\Salesforce\Common\ApiTokenService;
use App\Service\Salesforce\Common\Config;
use App\Service\Salesforce\Customer\LeadSenderService;
use App\Service\Salesforce\Dto\CustomerLeadDto;
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

    public function testSendLeadSuccess(): void
    {
        $httpClient = $this->createMock(HttpClientInterface::class);
        $httpClient->expects($this->any())
            ->method('request')
            ->willReturn($this->mockResponce());

        $lead = $this->createLead();
        $leadSenderService = new LeadSenderService($httpClient, $this->mockApiTockenService(), $this->mockConfig());
        $result = $leadSenderService->sendCustomer($lead, 'apiUrl', 'token');

        //"[{"leadId":"00Q9V00000KTaSnUAL","type":"Lead creation","status":"success"}]";
        //$content = '[{"leadId":"00Q9V00000KTaSnUAL","type":"Lead creation","status":"success"}]';
        //$data = json_decode($content, true);
        //var_dump($data);

        //var_dump($result);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('leadId', $result[0]);
        $this->assertArrayHasKey('type', $result[0]);
        $this->assertArrayHasKey('status', $result[0]);
        $this->assertEquals('00Q9V00000KTaSnUAL', $result[0]['leadId']);
        $this->assertEquals('success', $result[0]['status']);
    }

    public function testSendLeadError(): void
    {
        $httpClient = $this->createMock(HttpClientInterface::class);
        $httpClient->expects($this->any())
            ->method('request')
            ->willReturn($this->mockResponce(false));

        $lead = $this->createLead();
        $leadSenderService = new LeadSenderService($httpClient, $this->mockApiTockenService(), $this->mockConfig());
        $result = $leadSenderService->sendCustomer($lead, 'apiUrl', 'token');

        //"[{"message":"You're creating a duplicate record. We recommend you use an existing record instead.. CustomerId: 227","type":"DML error","status":"error"}]"
        //var_dump($result);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('message', $result[0]);
        $this->assertArrayHasKey('type', $result[0]);
        $this->assertArrayHasKey('status', $result[0]);
        $this->assertEquals('error', $result[0]['status']);
    }

    private function mockApiTockenService()
    {
        $service = $this->createMock(ApiTokenService::class);
        $service->expects($this->any())
            ->method('getToken')
            ->willReturn('test');

        return $service;
    }

    private function mockConfig()
    {
        $config = $this->createMock(Config::class);
        $config->expects($this->any())
            ->method('getPrefix')
            ->willReturn('test');

        return $config;
    }

    private function mockResponce(bool $success = true): ResponseInterface
    {
        //Symfony\Component\HttpClient\Response\TraceableResponse
        //$response = new Symfony\Component\HttpClient\Response\TraceableResponse();

        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->any())
            ->method('getStatusCode')
            ->willReturn(200);

        $content = '[{"leadId":"00Q9V00000KTaSnUAL","type":"Lead creation","status":"success"}]';
        if (!$success) {
            $content = '[{"message":"You\'re creating a duplicate record. We recommend you use an existing record instead.. CustomerId: 227","type":"DML error","status":"error"}]';
        }

        $response->expects($this->any())
            ->method('getContent')
            ->willReturn($content);

        return $response;
    }

    private function createLead() :CustomerLeadDto
    {
        return new CustomerLeadDto(
            1,
            self::EMAIL,
            'FirstName',
            'LastName',
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
