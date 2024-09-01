<?php

namespace App\Service\BloomreachMailer;

class Config
{
    public const API_URL = 'https://api.exponea.com';

    public function getApiKeyId(int $websiteId): string
    {
        return $_ENV["BLOOMREACH_API_PUBLIC_KEY"];
    }
    public function getApiSecret(int $websiteId): string
    {
        return $_ENV["BLOOMREACH_API_PRIVATE_KEY"];
    }
    public function getProjectTokenId(int $websiteId): string
    {
        return $_ENV["BLOOMREACH_API_PROJECT_TOKEN"];
    }

    public function getAuthData(int $websiteId): array
    {
        return [$this->getApiKeyId($websiteId), $this->getApiSecret($websiteId)];
    }

//    public function getApiTarget(int $websiteId): string
//    {
//        return $_ENV["GOOGLE_GEOCODING_API_KEY"];
//    }

    public function getEmailIntegrationId(int $websiteId): string
    {
        return $_ENV["BLOOMREACH_API_INTEGRATION_ID"];
    }

    public function getEmailStatusByType(string $emailType, int $websiteId): bool
    {
        return '';
    }

    public function getEmailTemplateIdByType(string $emailType, int $websiteId): string
    {
        return '66c4711aab26787e28c120fb';
    }
}
