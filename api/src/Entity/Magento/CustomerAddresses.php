<?php

namespace App\Entity\Magento;

use App\Repository\Magento\CustomerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CustomerAddressesRepository::class)]
#[ORM\Table(name: 'customer_addresses_entity')]
class CustomerAddresses
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'entity_id', type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(name: 'parent_id', type: 'integer', nullable: true)]
    private ?string $websiteId = null;

    #[ORM\Column(name: 'string', type: 'city', nullable: true)]
    private ?string $city = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
