<?php

namespace App\Repository;

use App\Entity\FraisType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FraisType|null find($id, $lockMode = null, $lockVersion = null)
 * @method FraisType|null findOneBy(array $criteria, array $orderBy = null)
 * @method FraisType[]    findAll()
 * @method FraisType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FraisTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FraisType::class);
    }

    // /**
    //  * @return FraisType[] Returns an array of FraisType objects
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

    /*
    public function findOneBySomeField($value): ?FraisType
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
