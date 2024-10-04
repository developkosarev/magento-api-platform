<?php

namespace App\Handler;

use App\Email\EmailFactoryInterface;
use App\Message\ExternalEmail;
use App\Service\Bloomreach\Mailer\SenderServiceInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Serializer\SerializerInterface;

#[AsMessageHandler]
readonly class ExternalEmailHandler
{
    public function __construct(
        private LoggerInterface $logger,
        private EmailFactoryInterface $emailFactory,
        private SerializerInterface $serializer,
        private SenderServiceInterface $senderService
    ) {}

    public function __invoke(ExternalEmail $email): void
    {
        $properties = $email->getProperties();
        $body = $email->getBody();

        $emailType = $properties['type'];
        $emailObj = $this->emailFactory->create($emailType);
        $emailObj = $this->serializer->denormalize($body, get_class($emailObj)); //$email->populate();

        $this->senderService->sendEmail($emailObj);

        $this->logger->warning('APP1-v1: {EMAIL_TYPE} - ' . $emailType);
    }
}
