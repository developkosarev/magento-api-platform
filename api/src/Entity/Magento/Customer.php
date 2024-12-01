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
    private ?int $id = null;

    #[ORM\Column(name: 'website_id', type: 'smallint', nullable: true)]
    private ?string $websiteId = null;

    #[ORM\Column(name: 'email', type: 'string', nullable: true)]
    private ?string $email = null;


    public function getId(): ?int
    {
        return $this->id;
    }
}
