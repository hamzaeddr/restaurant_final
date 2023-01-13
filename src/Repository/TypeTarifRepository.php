<?php

namespace App\Repository;

use App\Entity\TypeTarif;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TypeTarif|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeTarif|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeTarif[]    findAll()
 * @method TypeTarif[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeTarifRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeTarif::class);
    }

    // /**
    //  * @return TypeTarif[] Returns an array of TypeTarif objects
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
    public function findOneBySomeField($value): ?TypeTarif
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
