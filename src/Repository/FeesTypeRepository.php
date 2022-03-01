<?php

namespace App\Repository;

use App\Entity\FeesType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FeesType|null find($id, $lockMode = null, $lockVersion = null)
 * @method FeesType|null findOneBy(array $criteria, array $orderBy = null)
 * @method FeesType[]    findAll()
 * @method FeesType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FeesTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FeesType::class);
    }

    // /**
    //  * @return FeesType[] Returns an array of FeesType objects
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
    public function findOneBySomeField($value): ?FeesType
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
