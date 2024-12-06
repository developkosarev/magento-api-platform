<?php

namespace App\Service\Salesforce\Customer;

use DateTime;

interface LeadCustomerServiceInterface
{
    public function populateCustomers(DateTime $startDate, DateTime $endDate): void;

    public function sendCustomers(): void;
}
