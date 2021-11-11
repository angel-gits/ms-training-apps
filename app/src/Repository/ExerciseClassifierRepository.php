<?php

namespace App\Repository;

use App\Entity\ExerciseClassifier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ExerciseClassifier|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExerciseClassifier|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExerciseClassifier[]    findAll()
 * @method ExerciseClassifier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExerciseClassifierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExerciseClassifier::class);
    }

    // /**
    //  * @return ExerciseClassifier[] Returns an array of ExerciseClassifier objects
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
    public function findOneBySomeField($value): ?ExerciseClassifier
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findLikeByName($value) {
        return $this->createQueryBuilder('c')
            ->orWhere('c.name LIKE :name')
            ->setParameter('name', '%' . $value . '%')
            ->getQuery()
            ->execute();
    } 
}
