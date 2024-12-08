<?php

namespace App\Service\Salesforce\Customer;

use App\Service\Salesforce\Dto\CustomerLeadDto;

interface LeadSenderServiceInterface
{
    public function sendCustomer(CustomerLeadDto $leadDto, string $apiUrl, string $token): array;
}
