<?php

namespace App\Email;

interface EmailSerializerInterface
{
    public function serialize(EmailInterface $email): string;

    public function deserialize(string $message): EmailInterface;
}
