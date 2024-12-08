<?php

namespace App\Service\Salesforce\Dto;

use Symfony\Component\Serializer\Annotation\SerializedName;

class CustomerLeadDto implements CustomerLeadDtoInterface
{
    #[SerializedName('CustomerID')]
    private int $customerId;

    #[SerializedName('Email')]
    private string $email;

    #[SerializedName('FirstName')]
    private string $firstName;

    #[SerializedName('LastName')]
    private string $lastName;

    #[SerializedName('Street')]
    private string $street;

    #[SerializedName('PostalCode')]
    private string $postcode;

    #[SerializedName('City')]
    private string $city;

    #[SerializedName('Country')]
    private string $countryId;

    #[SerializedName('Phone')]
    private string $phone;

    #[SerializedName('Company')]
    private string $company;

    #[SerializedName('VAT_Number')]
    private string $taxvat;

    public function __construct(
        int $customerId,
        string $email,
        string $firstName,
        string $lastName,
        string $street,
        string $postcode,
        string $city,
        string $countryId,
        string $phone,
        string $company,
        string $taxvat
    )
    {
        $this->customerId = $customerId;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->street = $street;
        $this->postcode = $postcode;
        $this->city = $city;
        $this->countryId = $countryId;
        $this->phone = $phone;
        $this->company = $company;
        $this->taxvat = $taxvat;
    }

    public static function create(
        int $customerId,
        string $email,
        string $firstName,
        string $lastName,
        string $street,
        string $postcode,
        string $city,
        string $countryId,
        string $phone,
        string $company,
        string $taxvat
    ): CustomerLeadDto
    {
        return new self(
            $customerId,
            $email,
            $firstName,
            $lastName,
            $street,
            $postcode,
            $city,
            $countryId,
            $phone,
            $company,
            $taxvat
        );
    }

    public static function createByInterface(CustomerLeadDtoInterface $lead): CustomerLeadDto
    {
        return new self(
            $lead->getCustomerId(),
            $lead->getEmail(),
            $lead->getFirstName(),
            $lead->getLastName(),
            $lead->getStreet(),
            $lead->getPostcode(),
            $lead->getCity(),
            $lead->getCountryId(),
            $lead->getPhone(),
            $lead->getCompany(),
            $lead->getTaxvat()
        );
    }

    public function getCustomerId(): int
    {
        return $this->customerId;
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

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getPostcode(): string
    {
        return $this->postcode;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getCountryId(): string
    {
        return $this->countryId;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getCompany(): string
    {
        return $this->company;
    }

    public function getTaxvat(): string
    {
        return $this->taxvat;
    }
}
