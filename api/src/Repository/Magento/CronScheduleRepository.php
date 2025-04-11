<?php

namespace App\Repository\Magento;

use App\Entity\Magento\CronSchedule;
use Doctrine\ORM\EntityRepository;

class CronScheduleRepository extends EntityRepository
{
    public function getRunningCron(): array
    {
        $qb = $this->createQueryBuilder('cron');

        $qb->select('cron')
            ->andWhere('cron.status = :status')
            ->setParameter('status', CronSchedule::STATUS_RUNNING);

        return $qb->getQuery()->execute();
    }

    public function save(CronSchedule $cronSchedule, $force = true): void
    {
        $this->getEntityManager()->persist($cronSchedule);
        if ($force) {
            $this->getEntityManager()->flush();
        }
    }
}
