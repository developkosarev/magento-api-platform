<?php

namespace App\Service\Salesforce\Common;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\CacheInterface;

readonly class ApiTokenService
{
    public const ACCESS_TOKEN = 'access_token';
    public const INSTANCE_URL = 'instance_url';
    public const TOKEN_TYPE = 'token_type';
    public const ISSUED_AT = 'issued_at';
    public const SIGNATURE = 'signature';

    private CacheInterface $cache;

    public function __construct(
        private HttpClientInterface $httpClient,
        private string              $apiUrl,
        private string              $clientId,
        private string              $clientSecret,
        private string              $username,
        private string              $password
    ) {
        $this->cache = new FilesystemAdapter();
    }

    public function getToken(): string
    {
        return $this->getAccessTokens()[self::ACCESS_TOKEN];
    }

    public function getInstanceUrl(): string
    {
        return $this->getAccessTokens()[self::INSTANCE_URL];
    }

    private function getAccessTokens(): array
    {
        return $this->cache->get('access_token', function (ItemInterface $item) {
            $item->expiresAfter(3600);

            $response = $this->httpClient->request('POST', $this->getUrl());

            $data = $response->toArray();

            if (!isset($data[self::ACCESS_TOKEN])) {
                throw new \RuntimeException('Failed to retrieve access token');
            }

            return $data;
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
