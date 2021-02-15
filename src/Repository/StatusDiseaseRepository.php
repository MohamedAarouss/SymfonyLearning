<?php

namespace App\Repository;

use App\Entity\StatusDisease;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StatusDisease|null find($id, $lockMode = null, $lockVersion = null)
 * @method StatusDisease|null findOneBy(array $criteria, array $orderBy = null)
 * @method StatusDisease[]    findAll()
 * @method StatusDisease[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatusDiseaseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StatusDisease::class);
    }

    // /**
    //  * @return StatusDisease[] Returns an array of StatusDisease objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StatusDisease
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
