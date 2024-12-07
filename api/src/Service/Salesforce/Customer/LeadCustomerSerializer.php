<?php

namespace App\Service\Salesforce\Customer;

use App\Entity\Main\SalesforceCustomerLead;
use Symfony\Component\Serializer\SerializerInterface;

class LeadCustomerSerializer
{
    public function __construct(
        private SerializerInterface $serializer
    ) {}

    public function normalize(SalesforceCustomerLead $lead)
    {
        return $this->serializer->normalize($lead);
    }
}
