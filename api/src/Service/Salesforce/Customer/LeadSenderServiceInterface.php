<?php

namespace App\Service\Salesforce\Customer;

use App\Entity\Main\SalesforceCustomerLead;

interface LeadSenderServiceInterface
{
    public function sendCustomer(SalesforceCustomerLead $lead, string $apiUrl, string $token): array;
}
