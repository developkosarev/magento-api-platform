<?php

namespace App\Entity\Main\Salesforce;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\Main\Salesforce\CustomerLeadRepository;
use App\Service\Salesforce\Dto\CustomerLeadDtoInterface;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource(
    operations: [
        new Get(uriTemplate: '/salesforce/customer_lead/{id}'),
        new GetCollection(uriTemplate: '/salesforce/customer_lead'),
    ]
)]
#[ORM\Entity(repositoryClass: CustomerLeadRepository::class)]
#[ORM\Table(name: 'customer_lead')]
#[ORM\Index(columns: ['customer_id', 'created_at'], name: 'idx_customer_created_at')]
class CustomerLead implements CustomerLeadDtoInterface
{
    public const LEAD_STATUS_NEW = 'NEW';
    public const LEAD_STATUS_UPDATE = 'UPDATE';

    public const STATUS_NEW = 'NEW';
    public const STATUS_PROCESSED = 'PROCESSED';
    public const STATUS_ERROR = 'ERROR';

    #region Fields

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id', type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(name: 'created_at', type: 'datetime')]
    protected ?DateTime $createdAt;

    #[ORM\Column(name: 'lead_status', type: 'string', length: 6)]
    private ?string $leadStatus;

    #[ORM\Column(name: 'website_id', type: 'integer')]
    private ?int $websiteId;

    #[ORM\Column(name: 'customer_id', type: 'integer')]
    private ?int $customerId;

    #[ORM\Column(name: 'firstname', type: 'string', nullable: true)]
    private ?string $firstName;

    #[ORM\Column(name: 'lastname', type: 'string', nullable: true)]
    private ?string $lastName;

    #[ORM\Column(name: 'birthday', type: 'date', nullable: true)]
    public ?DateTime $birthday;

    #[ORM\Column(name: 'specialties', type: 'integer', nullable: true)]
    public ?string $specialties;

    #[ORM\Column(name: 'email', type: 'string', length: 255)]
    private ?string $email;

    #[ORM\Column(name: 'phone', type: 'string', length: 100, nullable: true)]
    private ?string $phone;

    #[ORM\Column(name: 'taxvat', type: 'string', length: 50, nullable: true)]
    private ?string $taxvat;

    #[ORM\Column(name: 'company', type: 'string', length: 255, nullable: true)]
    private ?string $company;

    #[ORM\Column(name: 'country_id', type: 'string', length: 255, nullable: true)]
    private ?string $countryId;

    #[ORM\Column(name: 'city', type: 'string', nullable: true)]
    private ?string $city;

    #[ORM\Column(name: 'street', type: 'text', nullable: true)]
    private ?string $street;

    #[ORM\Column(name: 'house_number', type: 'string', length: 255, nullable: true)]
    private ?string $houseNumber;

    #[ORM\Column(name: 'postcode', type: 'string', length: 255, nullable: true)]
    private ?string $postcode;

    #[ORM\Column(name: 'file_name', type: 'string', length: 255, nullable: true)]
    private ?string $fileName;

    #[ORM\Column(name: 'lead_id', type: 'string', length: 20, nullable: true)]
    private ?string $leadId;

    #[ORM\Column(name: 'attachment_id', type: 'string', length: 20, nullable: true)]
    private ?string $attachmentId;

    #[ORM\Column(name: 'description', type: 'string', length: 100, nullable: true)]
    private ?string $description;

    #[ORM\Column(name: 'status', type: 'string', length: 10, nullable: true)]
    private ?string $status;

    #[ORM\Column(type: 'integer')]
    #[ORM\Version]
    private int $version;

    #endregion

    #region Construct

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->leadStatus = self::LEAD_STATUS_NEW;
        $this->birthday = \DateTime::createFromFormat('Y-m-d', '1980-01-01');
    }

    #endregion

    #region Property

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function getLeadStatus(): string
    {
        return $this->leadStatus;
    }

    public function setLeadStatus(string $leadStatus): self
    {
        $this->leadStatus = $leadStatus;
        return $this;
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

    public function getCustomerId(): ?string
    {
        return (string) $this->customerId;
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

    public function getBirthday(): DateTime
    {
        if ($this->birthday === null) {
            return \DateTime::createFromFormat('Y-m-d', '1980-01-01');
        }

        return $this->birthday;
    }

    public function setBirthday(DateTime|string|null $birthday): self
    {
        if (is_string($birthday)) {
            $this->birthday = \DateTime::createFromFormat('Y-m-d', $birthday);
        } else {
            $this->birthday = $birthday;
        }

        return $this;
    }

    public function getSpecialties(): ?string
    {
        return (string) $this->specialties;
    }

    public function setSpecialties(?int $specialties): self
    {
        $this->specialties = $specialties;
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

    public function getCountryId(): ?string
    {
        return $this->countryId;
    }

    public function setCountryId(?string $countryId): self
    {
        $this->countryId = $countryId;
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

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(?string $street): self
    {
        $this->street = $street;
        return $this;
    }

    public function getHouseNumber(): ?string
    {
        return $this->houseNumber;
    }

    public function setHouseNumber(?string $houseNumber): self
    {
        $this->houseNumber = $houseNumber;
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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    public function getTaxvat(): ?string
    {
        return $this->taxvat;
    }

    public function setTaxvat(?string $taxvat): self
    {
        $this->taxvat = $taxvat;
        return $this;
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

    public function getCertificateImagePath(): ?string
    {
        $customerId = $this->getCustomerId();
        $fileName = $this->getFileName();

        return "/therapists/{$customerId}/{$fileName}";
    }


    public function getLeadId(): ?string
    {
        return $this->leadId;
    }

    public function setLeadId(?string $leadId): self
    {
        $this->leadId = $leadId;
        return $this;
    }

    public function getAttachmentId(): ?string
    {
        return $this->attachmentId;
    }

    public function setAttachmentId(?string $attachmentId): self
    {
        $this->attachmentId = $attachmentId;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getVersion(): int
    {
        return $this->version;
    }

    #endregion
}
