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
    #[ORM\Column(type: 'integer')]
    private ?int $entity_id = null;

    public function getId(): ?int
    {
        return $this->entity_id;
    }
}
