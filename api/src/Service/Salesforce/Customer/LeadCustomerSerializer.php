<?php

namespace App\Service\Salesforce\Customer;

use App\Service\Salesforce\Dto\CustomerLeadDto;
use Symfony\Component\Serializer\SerializerInterface;

class LeadCustomerSerializer
{
    public function __construct(
        private SerializerInterface $serializer
    ) {}

    public function normalize(CustomerLeadDto $customerLead)
    {
        return $this->serializer->normalize($customerLead);
    }
}
