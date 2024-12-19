<?php

namespace App\Service\Salesforce\Customer;

use App\Service\Salesforce\Common\ApiTokenService;
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
        private readonly LeadCustomerSerializer $leadCustomerSerializer
    ) {
    }

    public function sendCustomer(CustomerLeadDto $leadDto): array
    {
        $this->leadDto = $leadDto;
        $this->getToken();

        $payload = $this->getPayload();
        //var_dump($payload);

        /** @var $response Symfony\Component\HttpClient\Response\TraceableResponse */
        $response = $this->httpClient->request('POST', $this->getUrl(), [
            'auth_bearer' => $this->token,
            'json' => [$payload]
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
        return $this->leadCustomerSerializer->normalize($this->leadDto);
    }
}
