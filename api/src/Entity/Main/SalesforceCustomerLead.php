<?php

namespace App\Entity\Main;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\Main\SalesforceCustomerLeadRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

#[ApiResource(
    operations: [
        new Get(uriTemplate: '/customer_lead/{id}'),
        new GetCollection(uriTemplate: '/customer_lead'),
    ]
)]
#[ORM\Entity(repositoryClass: SalesforceCustomerLeadRepository::class)]
#[ORM\Table(name: 'customer_lead')]
class SalesforceCustomerLead
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id', type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'integer')]
    #[ORM\Version]
    private int $version;

    #[ORM\Column(name: 'website_id', type: 'integer')]
    private ?int $websiteId;

    #[ORM\Column(name: 'customer_id', type: 'integer')]
    private ?int $customerId;

    #[ORM\Column(name: 'firstname', type: 'string', nullable: true)]
    private ?string $firstName;

    #[ORM\Column(name: 'lastname', type: 'string', nullable: true)]
    private ?string $lastName;

    #[ORM\Column(name: 'email', type: 'string', length: 255)]
    private ?string $email;

    #[ORM\Column(name: 'phone', type: 'string', length: 100)]
    private ?string $phone;

    #[ORM\Column(name: 'taxvat', type: 'string', length: 50)]
    private ?string $taxvat;

    #[ORM\Column(name: 'company', type: 'string', length: 255)]
    private ?string $company;

    #[ORM\Column(name: 'country_id', type: 'string', length: 255, nullable: true)]
    private ?string $countryId;

    #[ORM\Column(name: 'street', type: 'text', nullable: true)]
    private ?string $street;

    #[ORM\Column(name: 'house_number', type: 'string', length: 255, nullable: true)]
    private ?string $houseNumber;

    #[ORM\Column(name: 'postcode', type: 'string', length: 255, nullable: true)]
    private ?string $postcode;

    #[ORM\Column(name: 'created_at', type: 'datetime', nullable: true)]
    protected ?DateTime $createdAt;

    #[ORM\Column(name: 'lead_id', type: 'string', length: 20, nullable: true)]
    private ?string $leadId;

    #[ORM\Column(name: 'description', type: 'string', length: 100, nullable: true)]
    private ?string $description;

    #[ORM\Column(name: 'status', type: 'string', length: 10, nullable: true)]
    private ?string $status;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVersion(): int
    {
        return $this->version;
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

    public function getCustomerId(): ?int
    {
        return $this->customerId;
    }

    public function setCustomerId(int $customerId): self
    {
        $this->customerId = $customerId;
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

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;
        return $this;
    }
}
