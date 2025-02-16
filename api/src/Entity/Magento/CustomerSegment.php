<?php

namespace App\Entity\Magento;

use App\Repository\Magento\CustomerSegmentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CustomerSegmentRepository::class)]
#[ORM\Table(name: 'sunday_customersegment_segment')]
class CustomerSegment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'segment_id', type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(name: 'name', type: 'string', nullable: true)]
    private ?string $name = null;

    #[ORM\Column(name: 'is_active', type: 'boolean', nullable: true)]
    private ?bool $isActive = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function isActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }
}
