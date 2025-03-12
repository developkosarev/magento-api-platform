<?php

namespace App\Scheduler\Handler\Bloomreach;

use App\Scheduler\Message\Bloomreach\LoadSegment;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class LoadSegmentHandler
{
    public function __construct(
        private readonly LoggerInterface $logger
    )
    {
    }
    public function __invoke(LoadSegment $message)
    {
        $this->logger->warning(str_repeat('🤎', 1) . ' Load segments');
    }
}
