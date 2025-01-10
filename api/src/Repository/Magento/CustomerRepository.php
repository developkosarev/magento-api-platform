<?php

namespace App\Repository\Magento;

use App\Entity\Magento\Customer;
use DateTime;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NativeQuery;
use Doctrine\ORM\Query\ResultSetMapping;

class CustomerRepository extends EntityRepository
{
    public function getLeads(DateTime $startDate, DateTime $endDate)
    {
        $rsm = new ResultSetMapping();
        $rsm->addEntityResult(Customer::class, 'c')
            ->addFieldResult('c', 'entity_id', 'entityId')
            ->addFieldResult('c', 'website_id', 'websiteId')
            ->addFieldResult('c', 'email', 'email')
            ->addFieldResult('c', 'firstname', 'firstName')
            ->addFieldResult('c', 'lastname', 'lastName')
            ->addFieldResult('c', 'dob', 'dob')
            ->addFieldResult('c', 'taxvat', 'taxVat')
            ->addFieldResult('c', 'default_billing', 'defaultBilling')
            ->addFieldResult('c', 'specialties', 'specialties');

        $nativeQuery = new NativeQuery($this->_em);
        $nativeQuery->setSQL($this->getSql());
        $nativeQuery->setResultSetMapping($rsm);
        $nativeQuery->setParameter('startDate', $startDate->format('Y-m-d'));
        $nativeQuery->setParameter('endDate', $endDate->format('Y-m-d'));
        $nativeQuery->setParameter('attribute_id', Customer::ATTRIBUTE_ID_SPECIALISATION);

        return $nativeQuery->getResult();

    }

    private function getSql(): string
    {
        //WHERE group_id = 61";

        return "SELECT customer_entity.entity_id,
                       customer_entity.website_id,
                       customer_entity.email,
                       customer_entity.group_id,
                       customer_entity.store_id,
                       customer_entity.created_at,
                       customer_entity.updated_at,
                       customer_entity.firstname,
                       customer_entity.lastname,
                       customer_entity.dob,
                       customer_entity.default_billing,
                       customer_entity.default_shipping,
                       customer_entity.taxvat,
                       customer_entity_int.value AS specialties
                FROM customer_entity
                INNER JOIN customer_entity_int ON customer_entity.entity_id = customer_entity_int.entity_id
                                              AND customer_entity_int.attribute_id = :attribute_id
                                              AND customer_entity_int.value > 0
                WHERE customer_entity.created_at BETWEEN :startDate AND :endDate AND customer_entity_int.value > 0 AND customer_entity.default_billing IS NOT NULL";
    }
}
