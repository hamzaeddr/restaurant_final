<?php

namespace App\Repository;

use App\Entity\FamilleCarte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FamilleCarte|null find($id, $lockMode = null, $lockVersion = null)
 * @method FamilleCarte|null findOneBy(array $criteria, array $orderBy = null)
 * @method FamilleCarte[]    findAll()
 * @method FamilleCarte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FamilleCarteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FamilleCarte::class);
    }

    // /**
    //  * @return FamilleCarte[] Returns an array of FamilleCarte objects
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

    
    // public function findOneByid($value): ?FamilleCarte
    // {
    //     return $this->createQueryBuilder('f')
    //         ->andWhere('f.IdFamilleC = :val')
    //         ->setParameter('val', $value)
    //         ->getQuery()
    //         ->getOneOrNullResult()
    //     ;
    // }
    
}
