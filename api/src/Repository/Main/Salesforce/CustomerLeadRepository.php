<?php

namespace App\Repository\Main\Salesforce;

use App\Entity\Main\Salesforce\CustomerLead;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CustomerLead>
 *
 * @method CustomerLead|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomerLead|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomerLead[]    findAll()
 * @method CustomerLead[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerLeadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CustomerLead::class);
    }

    public function add(CustomerLead $customerLead): CustomerLead
    {
        $this->_em->persist($customerLead);
        $this->_em->flush();

        return $customerLead;
    }

    public function findByStatusNew(): array
    {
        return $this->createQueryBuilder('lead')
            ->andWhere('lead.status = :status')
            ->setParameter('status', CustomerLead::STATUS_NEW)
            ->orderBy('lead.id', 'ASC')
            ->setMaxResults(100)
            ->getQuery()
            ->getResult();
    }
}
