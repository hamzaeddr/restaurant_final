<?php

namespace App\Repository;

use App\Entity\ProduitTarif;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProduitTarif|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProduitTarif|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProduitTarif[]    findAll()
 * @method ProduitTarif[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitTarifRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProduitTarif::class);
    }

    // /**
    //  * @return ProduitTarif[] Returns an array of ProduitTarif objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProduitTarif
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
