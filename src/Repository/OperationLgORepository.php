<?php

namespace App\Repository;

use App\Entity\OperationLgO;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OperationLgO|null find($id, $lockMode = null, $lockVersion = null)
 * @method OperationLgO|null findOneBy(array $criteria, array $orderBy = null)
 * @method OperationLgO[]    findAll()
 * @method OperationLgO[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OperationLgORepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OperationLgO::class);
    }

    // /**
    //  * @return OperationLgO[] Returns an array of OperationLgO objects
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
    public function findOneBySomeField($value): ?OperationLgO
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
