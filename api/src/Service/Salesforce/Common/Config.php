<?php

namespace App\Service\Salesforce\Common;

class Config
{
    public function getApiWebServiceUrl(): string
    {
        return $_ENV["SALESFORCE_API_WEB_SERVICE_URL"];
    }

    public function getApiClientId(): string
    {
        return $_ENV["SALESFORCE_API_CLIENT_ID"];
    }
    public function getApiClientSecret(): string
    {
        return $_ENV["SALESFORCE_API_CLIENT_SECRET"];
    }

    public function getApiPassword(): string
    {
        return $_ENV["SALESFORCE_API_PASSWORD"];
    }
}
