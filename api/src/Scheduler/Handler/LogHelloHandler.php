<?php

namespace App\Scheduler\Handler;

use App\Scheduler\Message\LogHello;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Psr\Log\LoggerInterface;

#[AsMessageHandler]
final class LogHelloHandler
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly EntityManagerInterface $entityManager,
        private readonly EntityManagerInterface $magentoEntityManager,
    )
    {
    }
    public function __invoke(LogHello $message)
    {
        if (!$this->entityManager->isOpen()) {
            $this->logger->warning('Entity Manager is closed');
        }
        if (!$this->magentoEntityManager->isOpen()) {
            $this->logger->warning('Magento Entity Manager is closed');
        }

        $this->logger->info(str_repeat('🎸', $message->length).' '.$message->length);
        $this->logger->notice(str_repeat('🎸', $message->length).' '.$message->length);
        $this->logger->warning(str_repeat('🎸', $message->length).' '.$message->length);
    }
}
