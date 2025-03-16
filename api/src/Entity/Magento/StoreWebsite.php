<?php

namespace App\Entity\Magento;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ApiResource(
    operations: [
        new GetCollection(),
    ]
)]
#[ORM\Entity]
#[ORM\Table(name: "store_website")]
#[ORM\Index(columns: ["default_group_id"], name: "STORE_WEBSITE_DEFAULT_GROUP_ID")]
#[ORM\Index(columns: ["sort_order"], name: "STORE_WEBSITE_SORT_ORDER")]
class StoreWebsite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::SMALLINT, options: ['unsigned' => true])]
    private ?int $websiteId = null;

    #[ORM\Column(type: Types::STRING, length: 32, unique: true, nullable: true)]
    private ?string $code = null;

    #[ORM\Column(type: Types::STRING, length: 64, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: Types::SMALLINT, options: ['unsigned' => true, 'default' => 0])]
    private int $sortOrder = 0;

    #[ORM\Column(type: Types::SMALLINT, options: ['unsigned' => true, 'default' => 0])]
    private int $defaultGroupId = 0;

    #[ORM\Column(type: Types::SMALLINT, nullable: true, options: ['unsigned' => true, 'default' => 0])]
    private ?int $isDefault = 0;

    // Getters and Setters
    public function getWebsiteId(): ?int
    {
        return $this->websiteId;
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
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

    public function getDefaultGroupId(): int
    {
        return $this->defaultGroupId;
    }

    public function setDefaultGroupId(int $defaultGroupId): self
    {
        $this->defaultGroupId = $defaultGroupId;
        return $this;
    }

    public function getIsDefault(): ?int
    {
        return $this->isDefault;
    }

    public function setIsDefault(?int $isDefault): self
    {
        $this->isDefault = $isDefault;
        return $this;
    }
}
