<?php

namespace App\Repository;

use App\Entity\ExercisePlan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ExercisePlan|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExercisePlan|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExercisePlan[]    findAll()
 * @method ExercisePlan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExercisePlanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExercisePlan::class);
    }

    // /**
    //  * @return ExercisePlan[] Returns an array of ExercisePlan objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ExercisePlan
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
