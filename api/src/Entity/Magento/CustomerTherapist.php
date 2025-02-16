<?php

namespace App\Entity\Magento;

use App\Repository\Magento\CustomerTherapistRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CustomerTherapistRepository::class)]
#[ORM\Table(name: 'customer_entity')]
class CustomerTherapist
{
    public const ATTRIBUTE_ID_SPECIALISATION = 583;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'entity_id', type: 'integer')]
    private ?int $entityId = null;

    #[ORM\Column(name: 'website_id', type: 'smallint', nullable: true)]
    private ?string $websiteId = null;

    #[ORM\Column(name: 'email', type: 'string', nullable: true)]
    private ?string $email = null;

    #[ORM\Column(name: 'increment_id', type: 'string', length: 50, nullable: true)]
    private ?string $incrementId = null;

    #[ORM\Column(name: 'firstname', type: 'string', nullable: true)]
    private ?string $firstName;

    #[ORM\Column(name: 'lastname', type: 'string', nullable: true)]
    private ?string $lastName;

    #[ORM\Column(name: 'dob', type: 'string', nullable: true)]
    private ?string $dob;

    #[ORM\Column(name: 'default_billing', type: 'integer', nullable: true)]
    private ?int $defaultBilling = null;

    #[ORM\Column(name: 'default_shipping', type: 'integer', nullable: true)]
    private ?int $defaultShipping = null;

    #[ORM\Column(name: 'taxvat', type: 'string', length: 50, nullable: true)]
    private ?string $taxVat = null;

    #[ORM\Column(name: 'specialties', type: 'integer', nullable: true)]
    private ?int $specialties = null;

    public function getId(): ?int
    {
        return $this->entityId;
    }

    public function getWebsiteId(): ?int
    {
        return $this->websiteId;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getIncrementId(): ?string
    {
        return $this->incrementId;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getDob(): ?string
    {
        return $this->dob;
    }

    public function getDefaultBilling(): ?int
    {
        return $this->defaultBilling;
    }

    public function getTaxVat(): ?string
    {
        return $this->taxVat;
    }

    public function getSpecialties(): ?int
    {
        return $this->specialties;
    }
}
