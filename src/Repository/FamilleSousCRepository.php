<?php

namespace App\Repository;

use App\Entity\FamilleSousC;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FamilleSousC|null find($id, $lockMode = null, $lockVersion = null)
 * @method FamilleSousC|null findOneBy(array $criteria, array $orderBy = null)
 * @method FamilleSousC[]    findAll()
 * @method FamilleSousC[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FamilleSousCRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FamilleSousC::class);
    }

    // /**
    //  * @return FamilleSousC[] Returns an array of FamilleSousC objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    
    // public function findOneByid($value): ?FamilleSousC
    // {
    //     return $this->createQueryBuilder('f')
    //         ->andWhere('f.id = :val')
    //         ->setParameter('val', $value)
    //         ->getQuery()
    //         ->getOneOrNullResult()
    //     ;
    // }
    
}
