<?php

namespace App\Repository\Magento;

use App\Entity\Magento\CustomerSegmentCustomer;
use App\Entity\Magento\CustomerSegmentWebsite;
use Doctrine\ORM\EntityRepository;

class CustomerSegmentCustomerRepository extends EntityRepository
{
    public function removeByUpdatedAt(CustomerSegmentWebsite $segmentWebsite, \DateTime $updatedAt): void
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();

        $queryBuilder
            ->delete(CustomerSegmentCustomer::class, 's')
            ->where('s.segment = :segment')
            ->andWhere('s.website = :website')
            ->andWhere('s.updatedAt <> :updatedAt')
            ->setParameter('segment', $segmentWebsite->getSegment())
            ->setParameter('website', $segmentWebsite->getWebsite())
            ->setParameter('updatedAt', $updatedAt)
            ->getQuery()
            ->execute();
    }
}
