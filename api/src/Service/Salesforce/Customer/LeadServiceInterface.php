<?php

namespace App\Service\Salesforce\Customer;

interface LeadServiceInterface
{
    public function createCustomer(string $email, string $apiUrl, string $token): array;
}
