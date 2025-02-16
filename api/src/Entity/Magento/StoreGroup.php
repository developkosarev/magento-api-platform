<?php

namespace App\Entity\Magento;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity]
#[ORM\Table(name: "store_group")]
#[ORM\Index(columns: ["default_store_id"], name: "STORE_GROUP_DEFAULT_STORE_ID")]
#[ORM\Index(columns: ["website_id"], name: "STORE_GROUP_WEBSITE_ID")]
class StoreGroup
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::SMALLINT, options: ['unsigned' => true])]
    private ?int $groupId = null;

    #[ORM\ManyToOne(targetEntity: StoreWebsite::class, inversedBy: "storeGroups")]
    #[ORM\JoinColumn(name: "website_id", referencedColumnName: "website_id", nullable: false, onDelete: "CASCADE")]
    private StoreWebsite $website;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $name;

    #[ORM\Column(type: Types::INTEGER, options: ['unsigned' => true, 'default' => 0])]
    private int $rootCategoryId = 0;

    #[ORM\Column(type: Types::SMALLINT, options: ['unsigned' => true, 'default' => 0])]
    private int $defaultStoreId = 0;

    #[ORM\Column(type: Types::STRING, length: 32, nullable: true, unique: true)]
    private ?string $code = null;

    // Getters and Setters
    public function getGroupId(): ?int
    {
        return $this->groupId;
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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getRootCategoryId(): int
    {
        return $this->rootCategoryId;
    }

    public function setRootCategoryId(int $rootCategoryId): self
    {
        $this->rootCategoryId = $rootCategoryId;
        return $this;
    }

    public function getDefaultStoreId(): int
    {
        return $this->defaultStoreId;
    }

    public function setDefaultStoreId(int $defaultStoreId): self
    {
        $this->defaultStoreId = $defaultStoreId;
        return $this;
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
}
