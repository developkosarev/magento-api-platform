<?php

namespace App\Service\Bloomreach\Common;

use App\Email\Newsletter;

class ConfigTemplate
{
    private ?string $template = null;

    public function getTemplate(string $emailType): ?string
    {
        $this->template = null;
        $this->getNewsLetterEmail($emailType);

        if ($this->template === null) {
            throw new \Exception("Can't get email object by email type - unknown type '%1'", $emailType);
        }

        return $this->template;
    }

    private function getNewsLetterEmail(string $emailType): void
    {
        switch ($emailType) {
            case Newsletter\SubscribeConfirmInterface::EMAIL_TYPE:
                $this->template = $_ENV["BLOOMREACH_TEMPLATE_NEWSLETTER_SUBSCRIBE_CONFIRM"];
                break;
            case Newsletter\SubscribeSuccessInterface::EMAIL_TYPE:
                $this->template = $_ENV["BLOOMREACH_TEMPLATE_NEWSLETTER_SUBSCRIBE_SUCCESS"];
                break;
        }
    }
}
