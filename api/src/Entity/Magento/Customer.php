<?php

namespace App\Entity\Magento;

use App\Repository\Magento\CustomerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
#[ORM\Table(name: 'customer_entity')]
class Customer
{
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
}
