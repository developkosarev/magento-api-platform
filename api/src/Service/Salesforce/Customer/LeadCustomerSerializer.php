<?php

namespace App\Service\Salesforce\Customer;

use App\Service\Salesforce\Dto\CustomerLeadDto;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

readonly class LeadCustomerSerializer
{
    public function __construct(
        private SerializerInterface $serializer
    ) {}

    public function normalize(CustomerLeadDto $customerLead)
    {
        return $this->serializer->normalize($customerLead,null,[AbstractObjectNormalizer::SKIP_NULL_VALUES => true]);
    }
}
