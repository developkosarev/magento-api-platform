<?php

namespace App\Email\Newsletter;

use App\Email\EmailInterface;

interface SubscribeConfirmInterface extends EmailInterface
{
    public const EMAIL_TYPE = 'NEWSLETTER_SUBSCRIBE_CONFIRM';
}
