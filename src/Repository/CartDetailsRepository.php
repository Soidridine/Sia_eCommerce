<?php

namespace App\Repository;

use App\Entity\CartDetails;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CartDetails|null find($id, $lockMode = null, $lockVersion = null)
 * @method CartDetails|null findOneBy(array $criteria, array $CartBy = null)
 * @method CartDetails[]    findAll()
 * @method CartDetails[]    findBy(array $criteria, array $CartBy = null, $limit = null, $offset = null)
 */
class CartDetailsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CartDetails::class);
    }

    // /**
    //  * @return CartDetails[] Returns an array of CartDetails objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->CartBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CartDetails
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