<?php

namespace App\Email;

use App\Message\Email\Newsletter as NewsletterEmail;

class EmailFactory implements EmailFactoryInterface
{
    private ?EmailInterface $emailObj;

    public function create(string $emailType): EmailInterface
    {
        $this->emailObj = null;
        $this->getNewsLetterEmail($emailType);

        if ($this->emailObj === null) {
            throw new \Exception("Can't get email object by email type - unknown type '%1'", $emailType);
        }

        return $this->emailObj;
    }
    private function getNewsLetterEmail(string $emailType): void
    {
        switch ($emailType) {
            case Newsletter\SubscribeConfirmInterface::EMAIL_TYPE:
                $this->emailObj = new Newsletter\SubscribeConfirm();
                break;
        }
    }
}
