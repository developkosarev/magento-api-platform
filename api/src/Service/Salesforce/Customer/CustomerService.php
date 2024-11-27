<?php

namespace App\Service\Salesforce\Customer;

use App\Service\Salesforce\Customer\CustomerServiceInterface;

class CustomerService implements CustomerServiceInterface
{
    public function createCustomer(string $email): bool
    {
        return true;
    }
}
