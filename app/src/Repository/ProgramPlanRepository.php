<?php

namespace App\Repository;

use App\Entity\ProgramPlan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;

/**
 * @method ProgramPlan|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProgramPlan|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProgramPlan[]    findAll()
 * @method ProgramPlan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProgramPlanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProgramPlan::class);
    }

    // /**
    //  * @return ProgramPlan[] Returns an array of ProgramPlan objects
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
    public function findOneBySomeField($value): ?ProgramPlan
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findLikeMathcesByValue($value) {
        return $this->createQueryBuilder('p')
            ->where('p.id LIKE :planId')
            ->orWhere('p.name LIKE :name')
            ->setParameter('planId', '%' . $value . '%')
            ->setParameter('name', '%' . $value . '%')
            ->getQuery()
            ->execute();
    }

    public function findLikeNameMathcesByValue($value) {
        return $this->createQueryBuilder('p')
            ->orWhere('p.name LIKE :name')
            ->setParameter('name', '%' . $value . '%')
            ->getQuery()
            ->execute();
    }
    
}
