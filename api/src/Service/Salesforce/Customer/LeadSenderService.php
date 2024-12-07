<?php

namespace App\Service\Salesforce\Customer;

use App\Entity\Main\SalesforceCustomerLead;
use App\Service\Salesforce\Common\Config;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class LeadSenderService implements LeadSenderServiceInterface
{
    private const ROUTE_LEAD = '/services/apexrest/magento/v1/leads';

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly Config              $config
    ) {
    }

    public function sendCustomer(SalesforceCustomerLead $lead, string $apiUrl, string $token): array
    {
        $url = $apiUrl . self::ROUTE_LEAD;

        $id = (string) $lead->getId();
        if (empty($this->config->getPrefix())) {
            $id = $this->config->getPrefix() . '-' . $id;
        }

        /** @var $response Symfony\Component\HttpClient\Response\TraceableResponse */
        $response = $this->httpClient->request('POST', $url, [
            'auth_bearer' => $token,
            'json' => [[
                'CustomerID' => $id,
                'FirstName' => $lead->getFirstName(),
                'LastName' => $lead->getLastName(),
                'Email' => $lead->getEmail(),
                'Specialties' => [
                    'Allergologe',
                    'Chiropraktiker'
                ],
                'Street' => $lead->getStreet(),
                'PostalCode' => "12345",
                'City' => 'Berlin',
                'Country' => 'DE',
                'Phone' => '1234567890',
                'Company' => 'HealthCare Inc',
                'VAT_Number' => 'DE123456789',
                'Documentation_Link' => 'https://example.com/document.pdf',
                'Status' => 'New',
                'Homepage' => 'https://www.therapist-homepage.com'
            ]]
        ]);

        //$statusCode = $response->getStatusCode(false);
        //var_dump($statusCode);

        $content = $response->getContent(false);
        //var_dump($content);

        return json_decode($content, true);
    }
}
