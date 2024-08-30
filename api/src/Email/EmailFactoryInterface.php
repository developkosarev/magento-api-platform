<?php

namespace App\Email;

interface EmailFactoryInterface
{
    public function create(string $emailType): EmailInterface;
}
