<?php

namespace App\Email\Newsletter;

use App\Email\AbstractEmail;

class SubscribeConfirm extends AbstractEmail implements SubscribeConfirmInterface
{
    private int $storeId;

    public function getBody(): array
    {
        return [];
    }

    public function getEmailType(): string
    {
        return self::EMAIL_TYPE;
    }

    public function getStoreId(): int
    {
        return $this->storeId;
    }

    public function setStoreId(int $storeId): self
    {
        $this->storeId = $storeId;
        return $this;
    }
}
