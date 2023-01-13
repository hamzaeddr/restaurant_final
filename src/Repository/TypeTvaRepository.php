<?php

namespace App\Repository;

use App\Entity\TypeTva;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TypeTva|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeTva|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeTva[]    findAll()
 * @method TypeTva[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeTvaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeTva::class);
    }

    // /**
    //  * @return TypeTva[] Returns an array of TypeTva objects
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
    public function findOneBySomeField($value): ?TypeTva
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
