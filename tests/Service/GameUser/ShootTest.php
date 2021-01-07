<?php

namespace App\Tests\Service\GameUser;

use App\Entity\GameUser;
use App\Entity\User;
use App\Entity\Weapon;
use App\Repository\WeaponRepository;
use App\Service\GameUser\GameUserInfo;
use App\Service\GameUser\Shoot;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Guard\Token\PostAuthenticationGuardToken;

class ShootTest extends TestCase
{


    public function testShootWithoutGameUser()
    {

        $this->expectException(\TypeError::class);

        $shoot = new Shoot(
            $this->createMock(EntityManager::class),
            $this->createMock(WeaponRepository::class),
            $this->createMock(SessionInterface::class),
            $this->createMock(TokenInterface::class),
            $this->createMock(GameUserInfo::class)
        );

        $shoot->shootGameUser();

    }

    public function testShootWithFailValue()
    {

        $this->expectException(\TypeError::class);

        $shoot = new Shoot(
            $this->createMock(EntityManager::class),
            $this->createMock(WeaponRepository::class),
            $this->createMock(SessionInterface::class),
            $this->createMock(TokenInterface::class),
            $this->createMock(GameUserInfo::class)
        );

        $shoot->shootGameUser('totot');

    }


    public function testShootWithGameUserAliveAndWeaponFull()
    {
        $weapon = new Weapon();
        $weapon->setAmmunition(Weapon::MAX_AMMUNITION);


        $weaponRepo = $this->createMock(WeaponRepository::class);
        $weaponRepo->expects($this->once())
            ->method('findWeaponByUserInHand')
            ->willReturn($weapon);

        $em = $this->createMock(EntityManager::class);
        $em->method('flush');

        $flashBag = $this->createMock(FlashBag::class);
        $session = $this->createMock(Session::class);
        $session->method('getFlashBag')
            ->willReturn($flashBag);
        $flashBag->method('add');

        $user = new User();
        $user->setUsername('Django');


        $tokenToken = $this->createMock(PostAuthenticationGuardToken::class);
        $tokenToken->method('getUser')
            ->willReturn($user);

        $token = $this->createMock(TokenStorage::class);
        $token->method('getToken')
            ->willReturn($tokenToken);

        $gameUserInfo = $this->createMock(GameUserInfo::class);
        $gameUserInfo->method('getReelDamage')
            ->willReturn(10);
        $gameUserInfo->method('IsAmmoEmpty')
            ->willReturn(false);

        $shoot = new Shoot(
            $em,
            $weaponRepo,
            $session,
            $token,
            $gameUserInfo
        );

        $gameUser = new GameUser();
        $gameUser->setHealth(50);
        $gameUser->setUser($user);

        $shoot->shootGameUser($gameUser);

        $this->assertEquals($gameUser->getHealth(), 40);
        $this->assertEquals($weapon->getAmmunition(), Weapon::MAX_AMMUNITION-1);

    }


    public function testShootWithGameUserAliveAndWeaponEmpty()
    {
        $weapon = new Weapon();
        $weapon->setAmmunition(0);


        $weaponRepo = $this->createMock(WeaponRepository::class);
        $weaponRepo->expects($this->once())
            ->method('findWeaponByUserInHand')
            ->willReturn($weapon);

        $em = $this->createMock(EntityManager::class);
        $em->method('flush');

        $flashBag = $this->createMock(FlashBag::class);
        $session = $this->createMock(Session::class);
        $session->method('getFlashBag')
            ->willReturn($flashBag);
        $flashBag->method('add');

        $user = new User();
        $user->setUsername('Django');


        $tokenToken = $this->createMock(PostAuthenticationGuardToken::class);
        $tokenToken->method('getUser')
            ->willReturn($user);

        $token = $this->createMock(TokenStorage::class);
        $token->method('getToken')
            ->willReturn($tokenToken);

        $gameUserInfo = $this->createMock(GameUserInfo::class);
        $gameUserInfo->method('getReelDamage')
            ->willReturn(10);
        $gameUserInfo->method('IsAmmoEmpty')
            ->willReturn(true);

        $shoot = new Shoot(
            $em,
            $weaponRepo,
            $session,
            $token,
            $gameUserInfo
        );

        $gameUser = new GameUser();
        $gameUser->setHealth(50);
        $gameUser->setUser($user);

        $shoot->shootGameUser($gameUser);

        $this->assertEquals($gameUser->getHealth(), 50);
        $this->assertEquals($weapon->getAmmunition(), 0);

    }


    public function testShootWithGameUserAliveAndWeaponNegative()
    {
        $weapon = new Weapon();
        $weapon->setAmmunition(-1);


        $weaponRepo = $this->createMock(WeaponRepository::class);
        $weaponRepo->expects($this->once())
            ->method('findWeaponByUserInHand')
            ->willReturn($weapon);

        $em = $this->createMock(EntityManager::class);
        $em->method('flush');

        $flashBag = $this->createMock(FlashBag::class);
        $session = $this->createMock(Session::class);
        $session->method('getFlashBag')
            ->willReturn($flashBag);
        $flashBag->method('add');

        $user = new User();
        $user->setUsername('Django');


        $tokenToken = $this->createMock(PostAuthenticationGuardToken::class);
        $tokenToken->method('getUser')
            ->willReturn($user);

        $token = $this->createMock(TokenStorage::class);
        $token->method('getToken')
            ->willReturn($tokenToken);

        $gameUserInfo = $this->createMock(GameUserInfo::class);
        $gameUserInfo->method('getReelDamage')
            ->willReturn(10);
        $gameUserInfo->method('IsAmmoEmpty')
            ->willReturn(true);

        $shoot = new Shoot(
            $em,
            $weaponRepo,
            $session,
            $token,
            $gameUserInfo
        );

        $gameUser = new GameUser();
        $gameUser->setHealth(50);
        $gameUser->setUser($user);

        $shoot->shootGameUser($gameUser);

        $this->assertEquals($gameUser->getHealth(), 50);
        $this->assertEquals($weapon->getAmmunition(), -1);

    }

    public function testShootWithGameUserAliveAndWeaponisOne()
    {
        $weapon = new Weapon();
        $weapon->setAmmunition(1);


        $weaponRepo = $this->createMock(WeaponRepository::class);
        $weaponRepo->expects($this->once())
            ->method('findWeaponByUserInHand')
            ->willReturn($weapon);

        $em = $this->createMock(EntityManager::class);
        $em->method('flush');

        $flashBag = $this->createMock(FlashBag::class);
        $session = $this->createMock(Session::class);
        $session->method('getFlashBag')
            ->willReturn($flashBag);
        $flashBag->method('add');

        $user = new User();
        $user->setUsername('Django');


        $tokenToken = $this->createMock(PostAuthenticationGuardToken::class);
        $tokenToken->method('getUser')
            ->willReturn($user);

        $token = $this->createMock(TokenStorage::class);
        $token->method('getToken')
            ->willReturn($tokenToken);

        $gameUserInfo = $this->createMock(GameUserInfo::class);
        $gameUserInfo->method('getReelDamage')
            ->willReturn(10);
        $gameUserInfo->method('IsAmmoEmpty')
            ->willReturn(false);

        $shoot = new Shoot(
            $em,
            $weaponRepo,
            $session,
            $token,
            $gameUserInfo
        );

        $gameUser = new GameUser();
        $gameUser->setHealth(50);
        $gameUser->setUser($user);

        $shoot->shootGameUser($gameUser);

        $this->assertEquals($gameUser->getHealth(), 40);
        $this->assertEquals($weapon->getAmmunition(), 0);

    }

    public function testShootWithGameUserAliveAndWeapon()
    {
        $weapon = new Weapon();
        $weapon->setAmmunition(-1);


        $weaponRepo = $this->createMock(WeaponRepository::class);
        $weaponRepo->expects($this->once())
            ->method('findWeaponByUserInHand')
            ->willReturn($weapon);

        $em = $this->createMock(EntityManager::class);
        $em->method('flush');

        $flashBag = $this->createMock(FlashBag::class);
        $session = $this->createMock(Session::class);
        $session->method('getFlashBag')
            ->willReturn($flashBag);
        $flashBag->method('add');

        $user = new User();
        $user->setUsername('Django');


        $tokenToken = $this->createMock(PostAuthenticationGuardToken::class);
        $tokenToken->method('getUser')
            ->willReturn($user);

        $token = $this->createMock(TokenStorage::class);
        $token->method('getToken')
            ->willReturn($tokenToken);

        $gameUserInfo = $this->createMock(GameUserInfo::class);
        $gameUserInfo->method('getReelDamage')
            ->willReturn(10);
        $gameUserInfo->method('IsAmmoEmpty')
            ->willReturn(true);

        $shoot = new Shoot(
            $em,
            $weaponRepo,
            $session,
            $token,
            $gameUserInfo
        );

        $gameUser = new GameUser();
        $gameUser->setHealth(50);
        $gameUser->setUser($user);

        $shoot->shootGameUser($gameUser);

        $this->assertEquals($gameUser->getHealth(), 50);
        $this->assertEquals($weapon->getAmmunition(), -1);

    }

}