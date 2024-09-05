<?php

namespace App\Email\Newsletter;

use App\Email\AbstractEmail;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

class SubscribeConfirm extends AbstractEmail implements SubscribeConfirmInterface
{
    private const ROUTE_CONFIRM_URL = 'newsletter/subscriber/confirm';
    private string $confirmCode;
    private string $storeName;
    private string $customerName;

    public function getEmailType(): string
    {
        return self::EMAIL_TYPE;
    }

    #[Groups(['body','params'])]
    #[SerializedName('confirm_code')]
    public function getConfirmCode(): string
    {
        return $this->confirmCode;
    }

    public function setConfirmCode(string $confirmCode): self
    {
        $this->confirmCode = $confirmCode;
        return $this;
    }

    #[Groups(['body','params'])]
    #[SerializedName('confirm_url')]
    public function getConfirmUrl(): string
    {
        return $this->getBaseUrl() . self::ROUTE_CONFIRM_URL . '/?code=' . $this->getConfirmCode();
    }

    #[Groups(['body','params'])]
    #[SerializedName('store_name')]
    public function getStoreName(): string
    {
        return $this->storeName;
    }

    public function setStoreName(string $storeName): self
    {
        $this->storeName = $storeName;
        return $this;
    }

    #[Groups(['body','params'])]
    #[SerializedName('customer_name')]
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
