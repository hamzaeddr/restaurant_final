<?php

namespace App\Repository;

use App\Entity\TypeFamille;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TypeFamille|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeFamille|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeFamille[]    findAll()
 * @method TypeFamille[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeFamilleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeFamille::class);
    }

    // /**
    //  * @return TypeFamille[] Returns an array of TypeFamille objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypeFamille
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
