<?php

namespace App\Service\Salesforce\Customer;

interface LeadSenderServiceInterface
{
    public function createCustomer(string $email, string $apiUrl, string $token): array;
}
