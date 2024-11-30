<?php

namespace App\Service\Salesforce\Common;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;

readonly class ApiTokenService
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private string              $apiUrl,
        private string              $clientId,
        private string              $clientSecret,
        private string              $username,
        private string              $password
    ) {
    }

    public function getToken(): string
    {
        $cache = new FilesystemAdapter();

        return $cache->get('api_token', function (ItemInterface $item) {
            $item->expiresAfter(3600);

            $response = $this->httpClient->request('POST', $this->getUrl());

            $data = $response->toArray();

            if (!isset($data['access_token'])) {
                throw new \RuntimeException('Failed to retrieve access token');
            }

            return $data['access_token'];
        });
    }

    private function getUrl(): string
    {
        return $this->apiUrl . '?grant_type=password' .
            '&client_id=' . $this->clientId .
            '&client_secret=' . $this->clientSecret .
            '&username=' . $this->username .
            '&password=' . $this->password;
    }
}
