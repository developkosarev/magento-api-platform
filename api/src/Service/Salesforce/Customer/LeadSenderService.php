<?php

namespace App\Service\Salesforce\Customer;

use App\Entity\Main\SalesforceCustomerLead;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class LeadSenderService implements LeadSenderServiceInterface
{
    private const ROUTE_LEAD = '/services/apexrest/magento/v1/leads';

    public function __construct(
        private readonly HttpClientInterface $httpClient
    ) {
    }

    public function sendCustomer(SalesforceCustomerLead $lead, string $apiUrl, string $token): array
    {
        $url = $apiUrl . self::ROUTE_LEAD;

        $response = $this->httpClient->request('POST', $url, [
            'auth_bearer' => $token,
            'json' => [[
                'CustomerID' => $lead->getId(),
                'FirstName' => $lead->getFirstName(),
                'LastName' => $lead->getLastName(),
                'Email' => $lead->getEmail(),
                'Specialties__c' => [
                    'Allergologe'
                ],
                'Street' => $lead->getStreet()
            ]]
        ]);

        $statusCode = $response->getStatusCode(false);
        var_dump($statusCode);

        $content = $response->getContent(false);
        var_dump($content);

        return $response->toArray();
    }

    public function createCustomer(string $email, string $apiUrl, string $token): array
    {
        $url = $apiUrl . self::ROUTE_LEAD;

        $response = $this->httpClient->request('POST', $url, [
            'auth_bearer' => $token,
            'json' => [
                'CustomerID' => "123456",
                'FirstName' => 'John',
                'LastName' => 'Doe',
                'Email' => 'demo@doctor.com',
                'Specialties__c' => [
                    'Allergologe'
                ],
                'Street' => '123 Main St'
            ]
        ]);

        $statusCode = $response->getStatusCode(false);
        //var_dump($statusCode);

        $content = $response->getContent(false);
        //var_dump($content);

        $data = $response->toArray(false);
        //var_dump($data);

        //if (!isset($data['access_token'])) {
        //    throw new \RuntimeException('Failed to retrieve access token');
        //}

        return $data;
    }
}
