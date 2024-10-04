<?php

namespace App\Service\Bloomreach\Mailer;

use App\Email\EmailInterface;

interface SenderServiceInterface
{
    public function sendEmail(EmailInterface $email): bool;
}
