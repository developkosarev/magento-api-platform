<?php

namespace App\Email;

use Symfony\Component\Serializer\Annotation\Groups;

abstract class AbstractEmail implements EmailInterface
{
    private string $email;
    private string $baseUrl;
    private int $websiteId;
    private int $storeId;

    #[Groups(['body'])]
    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    #[Groups(['body'])]
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function setBaseUrl(string $baseUrl): self
    {
        $this->baseUrl = $baseUrl;
        return $this;
    }

    #[Groups(['body'])]
    public function getWebsiteId(): int
    {
        return $this->websiteId;
    }

    public function setWebsiteId(int $websiteId): self
    {
        $this->websiteId = $websiteId;
        return $this;
    }

    #[Groups(['body'])]
    public function getStoreId(): int
    {
        return $this->storeId;
    }

    public function setStoreId(int $storeId): self
    {
        $this->storeId = $storeId;
        return $this;
    }
}
