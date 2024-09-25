<?php

namespace App\Scheduler\Handler;

use App\Scheduler\Message\LogHello;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Psr\Log\LoggerInterface;

#[AsMessageHandler]
final class LogHelloHandler
{
    public function __construct(private LoggerInterface $logger)
    {
    }
    public function __invoke(LogHello $message)
    {
        $this->logger->warning(str_repeat('🎸', $message->length).' '.$message->length);
    }
}
