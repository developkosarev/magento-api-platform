<?php

namespace App\Repository\Main;

use App\Entity\Main\SalesforceCustomerLead;
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
class SalesforceCustomerLeadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SalesforceCustomerLead::class);
    }

    public function add(SalesforceCustomerLead $customerLead): SalesforceCustomerLead
    {
        $lead = new SalesforceCustomerLead();
        $lead->setEmail($customerLead->getEmail());

        $this->_em->persist($lead);

        return $customerLead;
    }

    public function save(): void
    {
        $this->_em->flush();
    }

//    /**
//     * @return Orders[] Returns an array of Orders objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Orders
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
