<?php

namespace App\Entity\Magento;

use App\Repository\Magento\CustomerRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
#[ORM\Table(name: 'customer_entity')]
class Customer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'entity_id', type: Types::INTEGER)]
    private ?int $entityId = null;

    #[ORM\Column(name: 'website_id', type: Types::SMALLINT, nullable: true)]
    private ?int $websiteId = null;

    #[ORM\Column(name: 'email', type: Types::STRING, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(name: 'group_id', type: Types::SMALLINT, nullable: false)]
    private int $groupId = 0;

    #[ORM\Column(name: 'increment_id', type: Types::STRING, length: 50, nullable: true)]
    private ?string $incrementId = null;

    #[ORM\Column(name: 'store_id', type: Types::SMALLINT, options: ['unsigned' => true, 'default' => 0])]
    private int $storeId;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, options: ['default' => 'CURRENT_TIMESTAMP'])]
    public \DateTime $createdAt;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, options: ['default' => 'CURRENT_TIMESTAMP', 'onUpdate' => 'CURRENT_TIMESTAMP'])]
    public \DateTime $updatedAt;

    #[ORM\Column(name: 'is_active', type: 'boolean', options: ['unsigned' => true, 'default' => 1])]
    private int $isActive = 1;

    #[ORM\Column(type: Types::SMALLINT, options: ['unsigned' => true, 'default' => 0])]
    private int $disableAutoGroupChange = 0;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $createdIn = null;

    #[ORM\Column(type: Types::STRING, length: 40, nullable: true)]
    private ?string $prefix = null;

    #[ORM\Column(name: 'firstname', type: Types::STRING, nullable: true)]
    private ?string $firstName = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $middlename = null;

    #[ORM\Column(name: 'lastname', type: Types::STRING, nullable: true)]
    private ?string $lastName = null;

    #[ORM\Column(type: Types::STRING, length: 40, nullable: true)]
    private ?string $suffix = null;

    #[ORM\Column(name: 'dob', type: 'string', nullable: true)]
    private ?string $dob;

    #[ORM\Column(type: Types::STRING, length: 128, nullable: true)]
    private ?string $passwordHash = null;

    #[ORM\Column(type: Types::STRING, length: 128, nullable: true)]
    private ?string $rpToken = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTime $rpTokenCreatedAt = null;

    #[ORM\Column(name: 'default_billing', type: 'integer', nullable: true)]
    private ?int $defaultBilling = null;

    #[ORM\Column(name: 'default_shipping', type: 'integer', nullable: true)]
    private ?int $defaultShipping = null;

    #[ORM\Column(name: 'taxvat', type: 'string', length: 50, nullable: true)]
    private ?string $taxVat = null;

    #[ORM\Column(type: Types::STRING, length: 64, nullable: true)]
    private ?string $confirmation = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true, options: ['unsigned' => true])]
    private ?int $gender = null;

    #[ORM\Column(type: Types::SMALLINT, options: ['default' => 0])]
    private int $failuresNum = 0;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTime $firstFailure = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTime $lockExpires = null;

    #[ORM\Column(type: Types::INTEGER, options: ['default' => 0])]
    private int $payonePaydirektRegistered = 0;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTime $sessionCutoff = null;


    public function getId(): ?int
    {
        return $this->entityId;
    }

    public function setId(int $id): void
    {
        $this->entityId = $id;
    }

    public function getWebsiteId(): ?int
    {
        return $this->websiteId;
    }

    public function setWebsiteId(int $websiteId): self
    {
        $this->websiteId = $websiteId;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getGroupId(): ?int
    {
        return $this->groupId;
    }

    public function setGroupId(int $groupId): self
    {
        $this->groupId = $groupId;
        return $this;
    }

    public function getIncrementId(): ?string
    {
        return $this->incrementId;
    }

    public function getStoreId(): int
    {
        return $this->storeId;
    }

    public function setStoreId(int $storeId): self
    {
        $this->storeId = $storeId;
        return $this;
    }

    public function getCreatedIn(): ?string
    {
        return $this->createdIn;
    }

    public function setCreatedIn(?string $createdIn): self
    {
        $this->createdIn = $createdIn;
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

    public function getDob(): ?string
    {
        return $this->dob;
    }

    public function getPasswordHash(): ?string
    {
        return $this->passwordHash;
    }

    public function setPasswordHash(?string $passwordHash): self
    {
        $this->passwordHash = $passwordHash;
        return $this;
    }

    public function getRpToken(): ?string
    {
        return $this->rpToken;
    }

    public function setRpToken(?string $rpToken): self
    {
        $this->rpToken = $rpToken;
        return $this;
    }

    public function getDefaultBilling(): ?int
    {
        return $this->defaultBilling;
    }

    public function setDefaultBilling(?int $defaultBilling): self
    {
        $this->defaultBilling = $defaultBilling;
        return $this;
    }

    public function getDefaultShipping(): ?int
    {
        return $this->defaultShipping;
    }

    public function setDefaultShipping(?int $defaultShipping): self
    {
        $this->defaultShipping = $defaultShipping;
        return $this;
    }

    public function getTaxVat(): ?string
    {
        return $this->taxVat;
    }

    //public function getSpecialties(): ?int
    //{
    //    return $this->specialties;
    //}
}
