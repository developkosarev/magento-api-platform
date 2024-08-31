<?php

namespace App\Service\BloomreachMailer;

use App\Email\EmailInterface;

interface SenderServiceInterface
{
    public function sendEmail(EmailInterface $email): bool;
}
