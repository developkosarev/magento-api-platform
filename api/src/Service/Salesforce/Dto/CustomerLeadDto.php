<?php

namespace App\Service\Salesforce\Dto;

use DateTime;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

class CustomerLeadDto implements CustomerLeadDtoInterface
{
    #region Fields

    #[SerializedName('CustomerID')]
    private int $customerId;

    #[SerializedName('Email')]
    private string $email;

    #[SerializedName('FirstName')]
    private string $firstName;

    #[SerializedName('LastName')]
    private string $lastName;

    #[SerializedName('Street')]
    private ?string $street;

    #[SerializedName('Birthday')]
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
    public ?DateTime $birthday = null;

    #[SerializedName('Specialties')]
    public ?string $specialties = null;

    #[SerializedName('PostalCode')]
    private ?string $postcode = null;

    #[SerializedName('City')]
    private ?string $city = null;

    #[SerializedName('Country')]
    private ?string $countryId = null;

    #[SerializedName('Phone')]
    private ?string $phone = null;

    #[SerializedName('Company')]
    private ?string $company = null;

    #[SerializedName('VAT_Number')]
    private ?string $taxvat = null;

    #[SerializedName('Status')]
    private ?string $status = null;

    #[SerializedName('FileName')]
    private ?string $fileName = null;

    #[SerializedName('FileBase64')]
    private ?string $fileBase64 = null;

    #[SerializedName('ContentType')]
    private ?string $contentType = null;

    #endregion

    #region Construct

    public function __construct(
        int $customerId,
        string $email,
        string $firstName,
        string $lastName,
        DateTime $birthday
    )
    {
        $this->customerId = $customerId;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->birthday = $birthday;
        $this->status = CustomerLeadDtoInterface::STATUS_NEW;
    }

    public static function create(
        int $customerId,
        string $email,
        string $firstName,
        string $lastName,
        DateTime $birthday
    ): CustomerLeadDto
    {
        return new self(
            $customerId,
            $email,
            $firstName,
            $lastName,
            $birthday
        );
    }

    public static function createByInterface(CustomerLeadDtoInterface $lead): CustomerLeadDto
    {
        $leadDto = self::create(
            $lead->getCustomerId(),
            $lead->getEmail(),
            $lead->getFirstName(),
            $lead->getLastName(),
            $lead->getBirthday()
        );

        $leadDto
            ->setSpecialties($lead->getSpecialties())
            ->setStreet($lead->getStreet())
            ->setPostcode($lead->getPostcode())
            ->setCity($lead->getCity())
            ->setCountryId($lead->getCountryId())
            ->setPhone($lead->getPhone())
            ->setCompany($lead->getCompany())
            ->setTaxVat($lead->getTaxvat());

        return $leadDto;
    }

    #endregion

    #region Property

    public function getCustomerId(): string
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

    public function getBirthday(): DateTime
    {
        return $this->birthday;
    }

    public function getSpecialties(): ?string
    {
        return $this->specialties;
    }

    public function setSpecialties(?string $specialties): self
    {
        $this->specialties = $specialties;
        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(?string $street): self
    {
        $this->street = $street;
        return $this;
    }

    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    public function setPostcode(?string $postcode): self
    {
        $this->postcode = $postcode;
        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;
        return $this;
    }

    public function getCountryId(): ?string
    {
        return $this->countryId;
    }

    public function setCountryId(?string $countryId): self
    {
        $this->countryId = $countryId;
        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(?string $company): self
    {
        $this->company = $company;
        return $this;
    }

    public function getTaxvat(): ?string
    {
        return $this->taxvat;
    }

    public function setTaxVat(?string $taxVat): self
    {
        $this->taxvat = $taxVat;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(?string $fileName): self
    {
        $this->fileName = $fileName;
        return $this;
    }

    public function getFileBase64(): ?string
    {
        return $this->fileBase64;
    }

    public function setFileBase64(?string $fileBase64): self
    {
        $this->fileBase64 = $fileBase64;
        return $this;
    }

    public function getContentType(): ?string
    {
        return $this->contentType;
    }

    public function setContentType(?string $contentType): self
    {
        $this->contentType = $contentType;
        return $this;
    }

    #endregion
}
