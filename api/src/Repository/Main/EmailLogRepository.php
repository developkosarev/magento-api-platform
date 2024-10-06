<?php

namespace App\Repository\Main;

use App\Email\EmailInterface;
use App\Entity\Main\EmailLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EmailLog>
 *
 * @method EmailLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmailLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmailLog[]    findAll()
 * @method EmailLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmailLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmailLog::class);
    }

    public function add(EmailInterface $email): EmailLog
    {
        $emailLog = new EmailLog();
        $emailLog->setEmailType($email->getEmailType());

        $this->_em->persist($emailLog);

        return $emailLog;
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
