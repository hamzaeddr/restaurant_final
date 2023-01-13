<?php

namespace App\Repository;

use App\Entity\ClientBeneficiaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ClientBeneficiaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClientBeneficiaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClientBeneficiaire[]    findAll()
 * @method ClientBeneficiaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientBeneficiaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClientBeneficiaire::class);
    }

    // /**
    //  * @return ClientBeneficiaire[] Returns an array of ClientBeneficiaire objects
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
    public function findOneBySomeField($value): ?ClientBeneficiaire
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
