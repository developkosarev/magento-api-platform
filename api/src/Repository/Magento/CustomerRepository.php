<?php

namespace App\Repository\Magento;

use App\Entity\Magento\Customer;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NativeQuery;

class CustomerRepository extends EntityRepository
{
    //public function findById(string $orderId)
    //{
    //    return $this->findOneBy(['id' => $orderId]);
    //}

    public function getPartners()
    {
        $sql = "SELECT *";

        $nativeQuery = new NativeQuery($this->_em);
        $nativeQuery->setSQL($sql);
        //$nativeQuery->setResultSetMapping($rsm);

        return $nativeQuery->getResult();

    }
}
