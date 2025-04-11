<?php

namespace App\Scheduler\Handler;

use App\Scheduler\Message\CronVerification;
use App\Service\MagentoCron\CronVerificationServiceInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class CronVerificationHandler
{
    public function __construct(
        private readonly CronVerificationServiceInterface $cronVerificationService,
        private readonly LoggerInterface $logger
    )
    {
    }
    public function __invoke(CronVerification $message)
    {
        $msg = "Cron verification start";
        $this->logger->warning($msg);

        $this->cronVerificationService->execute(true);
    }
}
