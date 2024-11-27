<?php

namespace App\Service\Salesforce\Common;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;

class ApiTokenService
{
    private HttpClientInterface $httpClient;
    private string $apiUrl;
    private string $clientId;
    private string $clientSecret;

    public function __construct(
        HttpClientInterface $httpClient,
        string $apiUrl,
        string $clientId,
        string $clientSecret
    ) {
        $this->httpClient = $httpClient;
        $this->apiUrl = $apiUrl;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    public function getToken(): string
    {
        $cache = new FilesystemAdapter();

        return $cache->get('api_token', function (ItemInterface $item) {
            $item->expiresAfter(3600);

            $response = $this->httpClient->request('POST', $this->apiUrl, [
                'json' => [
                    'client_id' => $this->clientId,
                    'client_secret' => $this->clientSecret,
                    'grant_type' => 'client_credentials',
                ],
            ]);

            $data = $response->toArray();

            if (!isset($data['access_token'])) {
                throw new \RuntimeException('Failed to retrieve access token');
            }

            return $data['access_token'];
        });
    }
}
