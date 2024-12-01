<?php

namespace App\Repository\Magento;

use App\Entity\Magento\Customer;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NativeQuery;
use Doctrine\ORM\Query\ResultSetMapping;

class CustomerRepository extends EntityRepository
{
    //public function findById(string $orderId)
    //{
    //    return $this->findOneBy(['id' => $orderId]);
    //}

    public function getLeads()
    {
        $rsm = new ResultSetMapping();
        $rsm->addEntityResult(Customer::class, 'c')
            ->addFieldResult('c', 'entity_id', 'entityId')
            ->addFieldResult('c', 'website_id', 'websiteId')
            ->addFieldResult('c', 'email', 'email');

        $sql = "SELECT entity_id, website_id, email FROM customer_entity";

        $nativeQuery = new NativeQuery($this->_em);
        $nativeQuery->setSQL($sql);
        $nativeQuery->setResultSetMapping($rsm);

        return $nativeQuery->getResult();

    }
}
