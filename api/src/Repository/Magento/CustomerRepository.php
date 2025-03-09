<?php

namespace App\Repository\Magento;

use App\Entity\Magento\Customer;
use DateTime;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NativeQuery;
use Doctrine\ORM\Query\ResultSetMapping;

class CustomerRepository extends EntityRepository
{
    public function getCustomersByEmail(int $websiteId, array $emails): array
    {
        $qb = $this->createQueryBuilder('customer')
            ->select('customer')
            ->andWhere('customer.websiteId = :websiteId')
            ->andWhere('customer.email IN (:emails)')
            ->setParameter('websiteId', $websiteId)
            ->setParameter('emails', $emails);

        return $qb->getQuery()->execute();
    }
}
