<?php

namespace App\Service\Salesforce\Dto;

readonly class CustomerDto
{
    public function __construct(
        private int $id,
        private string $email,
        private string $firstName,
        private string $lastName
        //private string $specialties,
        //private string $street,
        //private string $number,
        //private string $postalCode,
        //private string $city,
        //private string $country,
        //private string $phone,
        //private string $company,
        //private string $vatNumber,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
    public function getFirstName(): string
    {
        return $this->firstName;
    }
    public function getLastName(): string
    {
        return $this->lastName;
    }
}
