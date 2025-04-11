<?php

namespace App\Repository\Magento;

use App\Entity\Magento\CronSchedule;
use Doctrine\ORM\EntityRepository;

class CronScheduleRepository extends EntityRepository
{
    public function CancelTasks(int $minutes): array
    {
        $qb = $this->createQueryBuilder('cron');

        $qb->select('cron')
            ->andWhere('cron.status = :status')
            ->setParameter('status', CronSchedule::STATUS_RUNNING);

        return $qb->getQuery()->execute();
    }
}
