<?php

namespace App\Email;

interface EmailInterface
{
    public function getEmailType(): string;

    public function getEmail(): string;

    public function setEmail(string $email): self;

    public function getBaseUrl(): string;

    public function setBaseUrl(string $baseUrl): self;

    public function getWebsiteId(): int;

    public function setWebsiteId(int $websiteId): self;

    public function getStoreId(): int;

    public function setStoreId(int $storeId): self;
}
