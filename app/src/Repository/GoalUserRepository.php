<?php

namespace App\Repository;

use App\Entity\GoalUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GoalUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method GoalUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method GoalUser[]    findAll()
 * @method GoalUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GoalUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GoalUser::class);
    }

    // /**
    //  * @return GoalUser[] Returns an array of GoalUser objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GoalUser
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
