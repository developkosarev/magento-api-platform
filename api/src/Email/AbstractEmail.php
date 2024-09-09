<?php

namespace App\Email;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

abstract class AbstractEmail implements EmailInterface
{
    private string $email;
    private string $language;
    private string $baseUrl;
    private int $websiteId;
    private int $storeId;

    #[Groups(['body'])]
    #[SerializedName('email')]
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
    #[SerializedName('language')]
    public function getLanguage(): string
    {
        return $this->language;
    }

    public function setLanguage(string $language): self
    {
        $this->language = $language;
        return $this;
    }

    #[Groups(['body'])]
    #[SerializedName('base_url')]
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
    #[SerializedName('website_id')]
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
    #[SerializedName('store_id')]
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
