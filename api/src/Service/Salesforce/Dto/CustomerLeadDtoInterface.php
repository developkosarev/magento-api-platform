<?php

namespace App\Service\Salesforce\Dto;

interface CustomerLeadDtoInterface
{
    public function getCustomerId(): ?int;
    public function getEmail(): ?string;
    public function getFirstName(): ?string;
    public function getLastName(): ?string;
    public function getStreet(): ?string;
    public function getPostcode(): ?string;
    public function getCity(): ?string;
    public function getCountryId(): ?string;
    public function getPhone(): ?string;
    public function getCompany(): ?string;
    public function getTaxvat(): ?string;
}
