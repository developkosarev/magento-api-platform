<?php

namespace App\Entity;

use App\Repository\OrdersRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrdersRepository::class)]
#[ORM\Table(name: 'sales_order')]
class Orders
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'entity_id', type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $mpGiftCards = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMpGiftCards(): ?string
    {
        return $this->mpGiftCards;
    }

    public function setMpGiftCards(string $value): self
    {
        $this->mpGiftCards = $value;
        return $this;
    }
}
