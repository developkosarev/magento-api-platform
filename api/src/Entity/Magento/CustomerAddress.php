<?php

namespace App\Entity\Magento;

use App\Repository\Magento\CustomerAddressRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: CustomerAddressRepository::class)]
#[ORM\Table(name: 'customer_address_entity')]
class CustomerAddress
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'entity_id', type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(name: 'parent_id', type: Types::INTEGER, nullable: true)]
    private ?int $parentId = null;

    #[ORM\Column(name: 'city', type: 'string', nullable: true)]
    private ?string $city = null;

    #[ORM\Column(name: 'company', type: 'string', nullable: true)]
    private ?string $company = null;

    #[ORM\Column(name: 'country_id', type: 'string', nullable: true)]
    private ?string $countryId = null;

    #[ORM\Column(name: 'firstname', type: Types::STRING, nullable: true)]
    private ?string $firstName = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $middlename = null;

    #[ORM\Column(name: 'lastname', type: Types::STRING, nullable: true)]
    private ?string $lastName = null;

    #[ORM\Column(name: 'region_id', type: Types::INTEGER, nullable: true)]
    private ?int $regionId = 0;

    #[ORM\Column(name: 'street', type: 'string', nullable: true)]
    private ?string $street = null;

    #[ORM\Column(name: 'postcode', type: 'string', nullable: true)]
    private ?string $postcode = null;

    #[ORM\Column(name: 'telephone', type: 'string', nullable: true)]
    private ?string $telephone = null;

    #[ORM\Column(name: 'vat_id', type: 'string', nullable: true)]
    private ?string $vatId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getParentId(): ?int
    {
        return $this->parentId;
    }

    public function setParentId(int $parentId): self
    {
        $this->parentId = $parentId;
        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;
        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function getCountryId(): ?string
    {
        return $this->countryId;
    }

    public function setCountryId(string $countryId): self
    {
        $this->countryId = $countryId;
        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getRegionId(): ?int
    {
        return $this->regionId;
    }

    public function setRegionId(int $regionId): self
    {
        $this->regionId = $regionId;
        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;
        return $this;
    }

    public function getHouseNumber(): ?string
    {
        return null;
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

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;
        return $this;
    }

    public function getVatId(): ?string
    {
        return $this->vatId;
    }
}
