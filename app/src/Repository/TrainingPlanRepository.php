<?php

namespace App\Repository;

use App\Entity\TrainingPlan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TrainingPlan|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrainingPlan|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrainingPlan[]    findAll()
 * @method TrainingPlan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrainingPlanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrainingPlan::class);
    }

    // /**
    //  * @return TrainingPlan[] Returns an array of TrainingPlan objects
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
    public function findOneBySomeField($value): ?TrainingPlan
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findLikeByValue($value) {
        return $this->createQueryBuilder('t')
            ->where('t.id LIKE :planId')
            ->orWhere('t.name LIKE :name')
            ->setParameter('planId', '%' . $value . '%')
            ->setParameter('name', '%' . $value . '%')
            ->getQuery()
            ->execute();
    }

    public function findLikeNameByValue($value) {
        return $this->createQueryBuilder('t')
            ->where('t.name LIKE :name')
            ->setParameter('name', '%' . $value . '%')
            ->getQuery()
            ->execute();
    }
}
