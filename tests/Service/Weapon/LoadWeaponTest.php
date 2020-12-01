<?php

namespace App\Tests\Service\WeaponUser;

use App\Entity\User;
use App\Entity\Weapon;
use App\Repository\WeaponRepository;
use App\Service\Weapon\Load;
use PHPUnit\Framework\TestCase;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Security\Guard\Token\PostAuthenticationGuardToken;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;

class LoadWeaponTest extends TestCase{

    private function initLoadWeapon($repoData){


        $repo = $this->createMock(WeaponRepository::class);
        $repo->expects($this->once())
            ->method('findWeaponByUser')
            ->willReturn($repoData);
        $em = $this->createMock(EntityManager::class);
        $em->expects($this->once())
            ->method('getRepository')
            ->willReturn($repo);
        $em->expects($this->once())
            ->method('flush');

        $flashBag = $this->createMock(FlashBag::class);
        $session = $this->createMock(Session::class);
        $session->expects($this->once())
            ->method('getFlashBag')
            ->willReturn($flashBag);
        $flashBag->expects($this->once())
            ->method('add');

        $user = $this->createMock(User::class);

        $tokenToken = $this->createMock(PostAuthenticationGuardToken::class);
        $tokenToken->expects($this->once())
            ->method('getUser')
            ->willReturn($user);

        $token = $this->createMock(TokenStorage::class);
        $token->expects($this->once())
            ->method('getToken')
            ->willReturn($tokenToken);

        return new Load($em, $session, $token);
    }

    /**
     * @expectedException TypeError
     */
    public function testLoadWithNoWeapon(){

        $loadWeapon = $this->initLoadWeapon();

        $loadWeapon->load(null);
    }

    /**
     * @expectedException TypeError
     */
    public function testLoadWithWeaponStrange(){

        $loadWeapon = $this->initLoadWeapon();

        $loadWeapon->load("une poule");
    }

    public function testLoadWithOneWeaponUnload()
    {

        $weapon = new Weapon();
        $weapon->setInHand(false);

        $loadWeapon = $this->initLoadWeapon([$weapon]);

        $loadWeapon->load($weapon);

        $this->assertTrue($weapon->getInHand());
    }

    public function testLoadWithOneWeaponLoad()
    {

        $weapon = new Weapon();
        $weapon->setInHand(true);

        $loadWeapon = $this->initLoadWeapon([$weapon]);

        $loadWeapon->load($weapon);

        $this->assertTrue($weapon->getInHand());
    }

    public function testLoadWiththreeWeaponUnload()
    {

        $weapon = new Weapon();
        $weapon->setInHand(false);

        $weapon1 = clone($weapon);
        $weapon2 = clone($weapon);


        $loadWeapon = $this->initLoadWeapon([$weapon, $weapon1, $weapon2]);

        $loadWeapon->load($weapon);

        $this->assertTrue($weapon->getInHand());
    }
}
