<?php

namespace App\Handler;

use App\Email\EmailFactoryInterface;
use App\Message\Email;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class EmailHandler
{
    public function __construct(
        private LoggerInterface $logger,
        private EmailFactoryInterface $emailFactory
    ) {}

    public function __invoke(Email $email): void
    {
        $body = $email->getBody();
        $emailType = $body['email_type'];

        $email = $this->emailFactory->create($emailType);
        //$email->populate();

        $this->logger->warning('APP1: {EMAIL_TYPE} - '.$body['email_type']);
    }
}
