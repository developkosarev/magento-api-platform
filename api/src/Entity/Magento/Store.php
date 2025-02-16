<?php

namespace App\Entity\Magento;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity]
#[ORM\Table(name: "store")]
#[ORM\Index(columns: ["group_id"], name: "STORE_GROUP_ID")]
#[ORM\Index(columns: ["is_active", "sort_order"], name: "STORE_IS_ACTIVE_SORT_ORDER")]
#[ORM\Index(columns: ["website_id"], name: "STORE_WEBSITE_ID")]
class Store
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::SMALLINT, options: ['unsigned' => true])]
    private ?int $storeId = null;

    #[ORM\Column(type: Types::STRING, length: 32, nullable: true, unique: true)]
    private ?string $code = null;

    #[ORM\ManyToOne(targetEntity: StoreWebsite::class, inversedBy: "stores")]
    #[ORM\JoinColumn(name: "website_id", referencedColumnName: "website_id", nullable: false, onDelete: "CASCADE")]
    private StoreWebsite $website;

    #[ORM\ManyToOne(targetEntity: StoreGroup::class, inversedBy: "stores")]
    #[ORM\JoinColumn(name: "group_id", referencedColumnName: "group_id", nullable: false, onDelete: "CASCADE")]
    private StoreGroup $group;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $name;

    #[ORM\Column(type: Types::SMALLINT, options: ['unsigned' => true, 'default' => 0])]
    private int $sortOrder = 0;

    #[ORM\Column(type: Types::SMALLINT, options: ['unsigned' => true, 'default' => 0])]
    private int $isActive = 0;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $hreflangCode = null;

    // Getters and Setters
    public function getStoreId(): ?int
    {
        return $this->storeId;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;
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

    public function getGroup(): StoreGroup
    {
        return $this->group;
    }

    public function setGroup(StoreGroup $group): self
    {
        $this->group = $group;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getSortOrder(): int
    {
        return $this->sortOrder;
    }

    public function setSortOrder(int $sortOrder): self
    {
        $this->sortOrder = $sortOrder;
        return $this;
    }

    public function getIsActive(): int
    {
        return $this->isActive;
    }

    public function setIsActive(int $isActive): self
    {
        $this->isActive = $isActive;
        return $this;
    }

    public function getHreflangCode(): ?string
    {
        return $this->hreflangCode;
    }

    public function setHreflangCode(?string $hreflangCode): self
    {
        $this->hreflangCode = $hreflangCode;
        return $this;
    }
}
