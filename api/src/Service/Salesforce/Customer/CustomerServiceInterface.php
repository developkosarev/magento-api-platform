<?php

namespace App\Service\Salesforce\Customer;

interface CustomerServiceInterface
{
    public function createCustomer(string $email): bool;
}
