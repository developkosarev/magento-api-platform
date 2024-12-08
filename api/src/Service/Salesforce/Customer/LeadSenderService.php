<?php

namespace App\Service\Salesforce\Customer;

use App\Service\Salesforce\Common\ApiTokenService;
use App\Service\Salesforce\Common\Config;
use App\Service\Salesforce\Dto\CustomerLeadDto;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class LeadSenderService implements LeadSenderServiceInterface
{
    private const ROUTE_LEAD = '/services/apexrest/magento/v1/leads';

    private string $token;
    private string $instanceUrl;
    private CustomerLeadDto $leadDto;

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly ApiTokenService     $apiTokenService,
        private readonly Config              $config
    ) {
    }

    public function sendCustomer(CustomerLeadDto $leadDto): array
    {
        $this->leadDto = $leadDto;
        $this->getToken();

        $customerId = (string) $leadDto->getCustomerId();
        if (empty($this->config->getPrefix())) {
            $customerId = $this->config->getPrefix() . '-' . $customerId;
        }

        /** @var $response Symfony\Component\HttpClient\Response\TraceableResponse */
        $response = $this->httpClient->request('POST', $this->getUrl(), [
            'auth_bearer' => $this->token,
            'json' => [$this->getPayload()]
        ]);

        //$statusCode = $response->getStatusCode(false);
        //var_dump($statusCode);

        $content = $response->getContent(false);
        //var_dump($content);

        return json_decode($content, true);
    }

    private function getToken(): void
    {
        $this->token = $this->apiTokenService->getToken();
        $this->instanceUrl = $this->apiTokenService->getInstanceUrl();
    }

    private function getUrl(): string
    {
        return $this->instanceUrl . self::ROUTE_LEAD;
    }

    private function getPayload(): array
    {
        return [
            'CustomerID' => $this->leadDto->getCustomerId(),
            'FirstName' => $this->leadDto->getFirstName(),
            'LastName' => $this->leadDto->getLastName(),
            'Email' => $this->leadDto->getEmail(),
            'Specialties' => [
                'Allergologe',
                'Chiropraktiker'
            ],
            'Street' => $this->leadDto->getStreet(),
            'PostalCode' => "12345",
            'City' => 'Berlin',
            'Country' => 'DE',
            'Phone' => '1234567890',
            'Company' => 'HealthCare Inc',
            'VAT_Number' => 'DE123456789',
            'Documentation_Link' => 'https://example.com/document.pdf',
            'Status' => 'New',
            'Homepage' => 'https://www.therapist-homepage.com'
        ];
    }
}
