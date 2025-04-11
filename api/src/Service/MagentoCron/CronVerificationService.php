<?php

namespace App\Service\MagentoCron;

use App\Entity\Magento\CronSchedule;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Psr\Log\LoggerInterface;

class CronVerificationService implements CronVerificationServiceInterface
{
    private const CRON_TIMEOUT = 30;

    private EntityRepository $mCronScheduleRepository;

    public function __construct(
        private readonly EntityManagerInterface $magentoEntityManager,
        private readonly LoggerInterface $logger
    ) {
        $this->mCronScheduleRepository = $this->magentoEntityManager->getRepository(CronSchedule::class);
    }

    public function execute(bool $force = true): void
    {
        $cronList = $this->mCronScheduleRepository->getRunningCron();

        $now = new \DateTime();
        $timeout = self::CRON_TIMEOUT;

        /** @var CronSchedule $item */
        foreach ($cronList as $item) {
            $executedAt = $item->getExecutedAt();
            if (!$executedAt instanceof \DateTimeInterface) {
                continue;
            }

            $diff = $executedAt->diff($now);
            $totalMinutes = ($diff->days * 24 * 60) + ($diff->h * 60) + $diff->i;

            if ($totalMinutes > $timeout && $diff->invert === 0) {
                $item->setStatusError();
                $this->mCronScheduleRepository->save($item, $force);

                $msg = "Cron more then {$timeout} min.: id={$item->getId()} job_code={$item->getJobCode()} time {$executedAt->format('Y-m-d H:i:s')}";
                $this->logger->warning($msg);
            }
        }

        $msg = "Cron verification Memory: {$this->getMemoryUsage()}MB";
        $this->logger->warning($msg);
    }

    private function getMemoryUsage(): float
    {
        $memUsage = memory_get_usage(true);
        return round($memUsage / 1048576, 2);
    }
}
