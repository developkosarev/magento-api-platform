<?php
declare(strict_types=1);

namespace App\Message;

readonly class ExternalEmail
{
    public function __construct(
        private array $properties,
        private array $body
    ){}

    public function getProperties(): array
    {
        return $this->properties;
    }

    public function getBody(): array
    {
        return $this->body;
    }
}
