<?php

namespace App\Service\Salesforce\Dto;

use DateTime;

interface CustomerLeadDtoInterface
{
    public function getCustomerId(): ?int;
    public function getEmail(): ?string;
    public function getFirstName(): ?string;
    public function getLastName(): ?string;
    public function getBirthday(): ?DateTime;
    public function getSpecialties(): ?int;
    public function getStreet(): ?string;
    public function getPostcode(): ?string;
    public function getCity(): ?string;
    public function getCountryId(): ?string;
    public function setCountryId(?string $countryId): self;
    public function getPhone(): ?string;
    public function setPhone(?string $phone): self;
    public function getCompany(): ?string;
    public function setCompany(?string $company): self;
    public function getTaxvat(): ?string;
    public function setTaxVat(?string $taxVat): self;
    public function getFileName(): ?string;
    public function setFileName(?string $fileName): self;
}
