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
            ->where('w.User = :user')
            ->setParameter('user', $user)
            ->innerJoin('w.WeaponType', 'wp')
            ->orderBy('wp.name', 'DESC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    public function findByWeaponTypeNameAndWeaponScarcity()
    {
        return $this->createQueryBuilder('w')
            ->innerJoin('w.WeaponType', 'wt')
            ->where('w.User is NULL')
            ->orderBy('wt.name')
            ->addOrderBy('w.scarcity')
            ->getQuery()
            ->getResult();
    }


    /*
    public function findOneBySomeField($value): ?Weapon
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
