<?php
declare(strict_types=1);

namespace App\Handler;

use App\Message\StatusUpdate;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class StatusUpdateHandler
{
    public function __construct(
        private LoggerInterface $logger,
    ) {}

    public function __invoke(StatusUpdate $statusUpdate): void
    {
        $statusDescription = $statusUpdate->getStatus();

        $this->logger->warning('APP1: {STATUS_UPDATE} - '.$statusDescription);
    }
}
