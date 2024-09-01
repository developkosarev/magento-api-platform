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


//    public function getAuthData(int $websiteId): array
//    {
//        return $_ENV["GOOGLE_GEOCODING_API_KEY"];
//    }
//
//    public function getApiTarget(int $websiteId): string
//    {
//        return $_ENV["GOOGLE_GEOCODING_API_KEY"];
//    }

    public function getEmailIntegrationId(int $websiteId): string
    {
        return '';
    }

    public function getEmailStatusByType(string $emailType, int $websiteId): bool
    {
        return '';
    }

    public function getEmailTemplateIdByType(string $emailType, int $websiteId): string
    {
        return '';
    }
}
