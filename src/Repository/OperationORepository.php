<?php

namespace App\Repository;

use App\Entity\OperationO;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OperationO|null find($id, $lockMode = null, $lockVersion = null)
 * @method OperationO|null findOneBy(array $criteria, array $orderBy = null)
 * @method OperationO[]    findAll()
 * @method OperationO[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OperationORepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OperationO::class);
    }

    // /**
    //  * @return OperationO[] Returns an array of OperationO objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OperationO
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
