<?php

namespace App\Entity\Main;

use App\Repository\Main\EmailLogRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

#[ApiResource(
    operations: [
        new Get(uriTemplate: '/email_log/{id}'),
        new GetCollection(uriTemplate: '/email_log'),
    ]
)]
#[ORM\Entity(repositoryClass: EmailLogRepository::class)]
#[ORM\Table(name: 'email_log')]
class EmailLog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id', type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(name: 'created_at', type: 'datetime', nullable: true)]
    protected ?DateTime $createdAt;

    #[ORM\Column(name: 'email_type', type: 'string', length: 100)]
    private ?string $emailType;

    #[ORM\Column(name: 'quantity', type: 'integer')]
    private int $quantity;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->quantity = 1;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function getEmailType(): ?string
    {
        return $this->emailType;
    }

    public function setEmailType(string $emailType): self
    {
        $this->emailType = $emailType;
        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
