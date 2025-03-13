<?php

namespace App\Entity\Magento;

use App\Repository\Magento\CustomerSegmentCustomerRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: CustomerSegmentCustomerRepository::class)]
#[ORM\Table(name: "sunday_customersegment_customer")]
#[ORM\Index(columns: ["customer_id"], name: "SUNDAY_CUSTOMERSEGMENT_CUSTOMER_CUSTOMER_ID")]
#[ORM\Index(columns: ["website_id"], name: "SUNDAY_CUSTOMERSEGMENT_CUSTOMER_WEBSITE_ID")]
#[ORM\UniqueConstraint(name: "SUNDAY_CSTRSEGMENT_CSTR_SEGMENT_ID_WS_ID_CSTR_ID", columns: ["segment_id", "website_id", "customer_id"])]
class CustomerSegmentCustomer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER, options: ['auto_increment' => true])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: CustomerSegment::class)]
    #[ORM\JoinColumn(name: "segment_id", referencedColumnName: "segment_id", nullable: false, onDelete: "CASCADE")]
    private CustomerSegment $segment;

    #[ORM\ManyToOne(targetEntity: Customer::class)]
    #[ORM\JoinColumn(name: "customer_id", referencedColumnName: "entity_id", nullable: false, onDelete: "CASCADE")]
    private Customer $customer;

    #[ORM\ManyToOne(targetEntity: StoreWebsite::class)]
    #[ORM\JoinColumn(name: "website_id", referencedColumnName: "website_id", nullable: false, onDelete: "CASCADE")]
    private StoreWebsite $website;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, options: ['default' => 'CURRENT_TIMESTAMP'])]
    public \DateTime $createdAt;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, options: ['default' => 'CURRENT_TIMESTAMP', 'onUpdate' => 'CURRENT_TIMESTAMP'])]
    public \DateTime $updatedAt;

    #[ORM\Column(name: "segment_value",type: Types::STRING, length: 255, nullable: true)]
    private ?string $segmentValue = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSegment(): CustomerSegment
    {
        return $this->segment;
    }

    public function setSegment(CustomerSegment $segment): self
    {
        $this->segment = $segment;
        return $this;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): self
    {
        $this->customer = $customer;
        return $this;
    }

    public function getWebsite(): StoreWebsite
    {
        return $this->website;
    }

    public function setWebsite(StoreWebsite $website): self
    {
        $this->website = $website;
        return $this;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    public function getSegmentValue(): ?string
    {
        return $this->segmentValue;
    }

    public function setSegmentValue(?string $value): self
    {
        $this->segmentValue = $value;
        return $this;
    }
}
