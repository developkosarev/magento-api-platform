<?php

namespace App\Email\Newsletter;

use App\Email\AbstractEmail;
use Symfony\Component\Serializer\Annotation\Groups;

class SubscribeConfirm extends AbstractEmail implements SubscribeConfirmInterface
{
    private string $confirmCode;
    private string $storeName;
    private string $customerName;

    public function getEmailType(): string
    {
        return self::EMAIL_TYPE;
    }

    #[Groups(['body'])]
    public function getConfirmCode(): string
    {
        return $this->confirmCode;
    }

    public function setConfirmCode(string $confirmCode): self
    {
        $this->confirmCode = $confirmCode;
        return $this;
    }

    #[Groups(['body'])]
    public function getStoreName(): string
    {
        return $this->storeName;
    }

    public function setStoreName(string $storeName): self
    {
        $this->storeName = $storeName;
        return $this;
    }

    #[Groups(['body'])]
    public function getCustomerName(): ?string
    {
        return $this->customerName;
    }

    public function setCustomerName(string $customerName): self
    {
        $this->customerName = $customerName;
        return $this;
    }
}
