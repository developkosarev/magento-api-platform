<?php

namespace App\Repository\Main\Salesforce;

use App\Entity\Main\Salesforce\SalesforceCustomerLead;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SalesforceCustomerLead>
 *
 * @method SalesforceCustomerLead|null find($id, $lockMode = null, $lockVersion = null)
 * @method SalesforceCustomerLead|null findOneBy(array $criteria, array $orderBy = null)
 * @method SalesforceCustomerLead[]    findAll()
 * @method SalesforceCustomerLead[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerLeadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SalesforceCustomerLead::class);
    }

    public function add(SalesforceCustomerLead $customerLead): SalesforceCustomerLead
    {
        $this->_em->persist($customerLead);
        $this->_em->flush();

        return $customerLead;
    }

    public function findByStatusNew(): array
    {
        return $this->createQueryBuilder('lead')
            ->andWhere('lead.status = :status')
            ->setParameter('status', SalesforceCustomerLead::STATUS_NEW)
            ->orderBy('lead.id', 'ASC')
            ->setMaxResults(100)
            ->getQuery()
            ->getResult();
    }
}
