<?php

namespace App\Repository;

use App\Entity\CheckBorne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CheckBorne|null find($id, $lockMode = null, $lockVersion = null)
 * @method CheckBorne|null findOneBy(array $criteria, array $orderBy = null)
 * @method CheckBorne[]    findAll()
 * @method CheckBorne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CheckBorneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CheckBorne::class);
    }

    // /**
    //  * @return CheckBorne[] Returns an array of CheckBorne objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CheckBorne
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
