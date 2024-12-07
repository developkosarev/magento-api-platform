<?php

namespace App\Entity\Main;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\Main\CustomerConsolidatedRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UlidType;
use Symfony\Component\Uid\Ulid;
use DateTime;

#[ApiResource(
    operations: [
        new Get(uriTemplate: '/customer-consolidated/{id}'),
        new GetCollection(uriTemplate: '/customer-consolidated'),
    ]
)]

#[ORM\Entity(repositoryClass: CustomerConsolidatedRepository::class)]
#[ORM\Table(name: 'customer_consolidated')]
class CustomerConsolidated
{
    //#[ORM\Id]
    //#[ORM\GeneratedValue]
    //#[ORM\Column(name: 'id', type: 'integer')]
    //private ?int $id = null;

    #[ORM\Id]
    #[ORM\Column(type: UlidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.ulid_generator')]
    private ?Ulid $id;

    #[ORM\Column(name: 'email', type: 'string', length: 255)]
    private ?string $email;

    #[ORM\Column(name: 'created_at', type: 'datetime', nullable: true)]
    protected ?DateTime $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    //public function getId(): ?int
    //{
    //    return $this->id;
    //}

    public function getId(): ?Ulid
    {
        return $this->id;
    }

    public function setId(Ulid $id): self
    {
        $this->id = $id;
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
}
