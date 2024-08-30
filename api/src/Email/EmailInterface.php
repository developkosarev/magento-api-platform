<?php

namespace App\Email;

interface EmailInterface
{
    public function getBody(): array;

    public function getEmailType(): string;

    public function getEmail(): string;

    public function setEmail(string $email): self;

    public function getWebsiteId(): int;

    public function setWebsiteId(int $websiteId): self;
}
