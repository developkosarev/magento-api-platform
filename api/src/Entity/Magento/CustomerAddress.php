<?php

namespace App\Entity\Magento;

use App\Repository\Magento\CustomerAddressRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CustomerAddressRepository::class)]
#[ORM\Table(name: 'customer_address_entity')]
class CustomerAddress
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'entity_id', type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(name: 'parent_id', type: 'integer', nullable: true)]
    private ?int $parentId = null;

    #[ORM\Column(name: 'city', type: 'string', nullable: true)]
    private ?string $city = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
