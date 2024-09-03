<?php

namespace App\Email\Newsletter;

use App\Email\EmailInterface;

interface SubscribeConfirmInterface extends EmailInterface
{
    public const EMAIL_TYPE = 'NEWSLETTER_SUBSCRIBE_CONFIRM';

    public function getConfirmCode(): string;
    public function setConfirmCode(string $confirmCode): self;
    public function getStoreName(): string;
    public function setStoreName(string $storeName): self;
    public function getCustomerName(): ?string;
    public function setCustomerName(string $customerName): self;
}
