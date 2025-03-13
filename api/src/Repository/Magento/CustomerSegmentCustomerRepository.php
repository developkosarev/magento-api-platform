<?php

namespace App\Repository\Magento;

use App\Entity\Magento\CustomerSegmentCustomer;
use Doctrine\ORM\EntityRepository;

class CustomerSegmentCustomerRepository extends EntityRepository
{
    public function removeByUpdatedAt(int $segmentId, int $websiteId, \DateTime $updatedAt): void
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();

        $queryBuilder
            ->delete(CustomerSegmentCustomer::class, 's')
            ->where('s.segmentId = :segmentId')
            ->andWhere('s.websiteId = :websiteId')
            ->andWhere('s.updatedAt <> :updatedAt')
            ->setParameter('segmentId', $segmentId)
            ->setParameter('websiteId', $websiteId)
            ->setParameter('updatedAt', $updatedAt)
            ->getQuery()
            ->execute();
    }
}
