<?php

namespace App\Service\Bloomreach\Customer;

interface CustomerServiceInterface
{
    public function createCustomer(string $email): bool;
}
