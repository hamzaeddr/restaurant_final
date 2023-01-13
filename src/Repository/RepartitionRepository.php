<?php

namespace App\Repository;

use App\Entity\Repartition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Repartition|null find($id, $lockMode = null, $lockVersion = null)
 * @method Repartition|null findOneBy(array $criteria, array $orderBy = null)
 * @method Repartition[]    findAll()
 * @method Repartition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RepartitionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Repartition::class);
    }

    // /**
    //  * @return Repartition[] Returns an array of Repartition objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Repartition
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
