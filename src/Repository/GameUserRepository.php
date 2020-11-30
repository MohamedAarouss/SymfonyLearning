<?php

namespace App\Repository;


use App\Entity\GameUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GameUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method GameUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method GameUser[]    findAll()
 * @method GameUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GameUser::class);
    }


}
