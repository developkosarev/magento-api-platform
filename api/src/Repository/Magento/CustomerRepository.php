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
            ->addFieldResult('c', 'email', 'email')
            ->addFieldResult('c', 'firstname', 'firstName')
            ->addFieldResult('c', 'lastname', 'lastName');

        $sql = "SELECT entity_id, website_id, email, firstname, lastname FROM customer_entity";

        $nativeQuery = new NativeQuery($this->_em);
        $nativeQuery->setSQL($this->getSql());
        $nativeQuery->setResultSetMapping($rsm);

        return $nativeQuery->getResult();

    }

    private function getSql(): string
    {
        //WHERE group_id = 61";

        return "SELECT customer_entity.entity_id,
                       customer_entity.website_id,
                       customer_entity.email,
                       customer_entity.store_id,
                       customer_entity.created_at,
                       customer_entity.updated_at,
                       customer_entity.firstname,
                       customer_entity.lastname,
                       customer_entity.default_billing,
                       customer_entity.default_shipping,
                       customer_entity.taxvat
                FROM customer_entity
                INNER JOIN customer_entity_int ON customer_entity.entity_id = customer_entity_int.entity_id
                                              AND customer_entity_int.attribute_id = 583
                                              AND customer_entity_int.value > 0";
    }
}
