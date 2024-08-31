<?php

namespace App\Service\BloomreachMailer;

use App\Email\EmailInterface;

class SenderService implements SenderServiceInterface
{
    //private RequestSenderInterface $requestSender;

    //public function __construct(RequestSenderInterface $requestSender)
    //{
    //    $this->requestSender = $requestSender;
    //}

    public function sendEmail(EmailInterface $email): bool
    {
        $websiteId = $email->getWebsiteId();

        return true;

        //$response = $this->requestSender
        //    ->execute(
        //        $this->getEndpoint($websiteId),
        //        self::REQUEST_TYPE,
        //        $this->optionsBuilder->create($email, $websiteId),
        //        $websiteId
        //    );
        //return $response->getStatusCode() == self::RESPONSE_STATUS_CODE_OK;
    }
}
