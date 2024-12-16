<?php

namespace App\Entity\Magento;

use App\Repository\Magento\CustomerAddressRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CustomerAddressRepository::class)]
#[ORM\Table(name: 'customer_address_entity')]
class CustomerAddress
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'entity_id', type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(name: 'parent_id', type: 'integer', nullable: true)]
    private ?int $parentId = null;

    #[ORM\Column(name: 'city', type: 'string', nullable: true)]
    private ?string $city = null;

    #[ORM\Column(name: 'company', type: 'string', nullable: true)]
    private ?string $company = null;

    #[ORM\Column(name: 'country_id', type: 'string', nullable: true)]
    private ?string $countryId = null;

    #[ORM\Column(name: 'street', type: 'string', nullable: true)]
    private ?string $street = null;

    #[ORM\Column(name: 'postcode', type: 'string', nullable: true)]
    private ?string $postcode = null;

    #[ORM\Column(name: 'telephone', type: 'string', nullable: true)]
    private ?string $telephone = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function getCountryId(): ?string
    {
        return $this->countryId;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function getHouseNumber(): ?string
    {
        return null;
    }

    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }
}
