<?php

namespace App\Repository;


use App\Entity\ActionUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ActionUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActionUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActionUser[]    findAll()
 * @method ActionUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActionUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActionUser::class);
    }


}
