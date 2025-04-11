<?php

namespace App\Service\MagentoCron;

use App\Entity\Magento\CronSchedule;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Psr\Log\LoggerInterface;

class CronVerificationService implements CronVerificationServiceInterface
{
    private EntityRepository $mCronScheduleRepository;

    public function __construct(
        private readonly EntityManagerInterface $magentoEntityManager,
        private readonly LoggerInterface $logger
    ) {
        $this->mCronScheduleRepository = $this->magentoEntityManager->getRepository(CronSchedule::class);
    }

    public function execute(): void
    {
        $msg = "Cron verification Memory: {$this->getMemoryUsage()}MB";
        $this->logger->warning($msg);

        $result = $this->mCronScheduleRepository->CancelTasks(30);

        var_dump($result);
    }

    private function getMemoryUsage(): float
    {
        $memUsage = memory_get_usage(true);
        return round($memUsage / 1048576, 2);
    }
}
