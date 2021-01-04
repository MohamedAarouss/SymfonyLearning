<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Weapon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Weapon|null find($id, $lockMode = null, $lockVersion = null)
 * @method Weapon|null findOneBy(array $criteria, array $orderBy = null)
 * @method Weapon[]    findAll()
 * @method Weapon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WeaponRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Weapon::class);
    }


    public function findByUserOrderWeaponTypeDesc(User $user)
    {
        return $this->createQueryBuilder('w')
            ->innerJoin('w.GameUser', 'gu')
            ->where('gu.User = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }

    public function findWeaponByUser(User $user, bool $inHand = null)
    {
        $qb = $this->createQueryBuilder('w')
            ->innerJoin('w.GameUser', 'gu')
            ->where('gu.User = :user')
            ->setParameter('user', $user);
        if(isset($inHand)){
            $qb->andWhere('w.inHand = :inHand')
                ->setParameter('inHand', $inHand);
        }
        return $qb->getQuery()
            ->getResult();
    }

    public function findWeaponByUserInHand(User $user)
    {
        $qb = $this->createQueryBuilder('w')
            ->innerJoin('w.GameUser', 'gu')
            ->where('gu.User = :user')
            ->setParameter('user', $user);
            $qb->andWhere('w.inHand = :inHand')
                ->setParameter('inHand', true);
        return $qb->getQuery()
            ->getOneOrNullResult();
    }

}
