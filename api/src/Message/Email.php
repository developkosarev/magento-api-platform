<?php
declare(strict_types=1);

namespace App\Message;

readonly class Email
{
    public function __construct(private array $body){}

    public function getBody(): array
    {
        return $this->body;
    }
}
