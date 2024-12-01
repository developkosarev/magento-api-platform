<?php

namespace App\Repository\Main;

use App\Entity\Main\CustomerConsolidated;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CustomerConsolidated>
 *
 * @method CustomerConsolidated|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomerConsolidated|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomerConsolidated[]    findAll()
 * @method CustomerConsolidated[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerConsolidatedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CustomerConsolidated::class);
    }
}
