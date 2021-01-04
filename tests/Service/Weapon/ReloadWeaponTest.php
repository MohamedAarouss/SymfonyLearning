<?php

namespace App\Tests\Service\Weapon;

use App\Entity\User;
use App\Entity\Weapon;
use App\Repository\WeaponRepository;
use App\Service\Weapon\Load;
use App\Service\Weapon\Reload;
use PHPUnit\Framework\TestCase;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Security\Guard\Token\PostAuthenticationGuardToken;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;

class ReloadWeaponTest extends TestCase
{

    private function initReloadWeaponError()
    {
        $em = $this->createMock(EntityManager::class);
        $em->method('flush');

        $flashBag = $this->createMock(FlashBag::class);
        $session = $this->createMock(Session::class);
        $session->method('getFlashBag')
            ->willReturn($flashBag);
        $flashBag->method('add');

        return new Reload($em, $session);
    }

    private function initReloadWeapon()
    {

        $em = $this->createMock(EntityManager::class);
        $em->expects($this->once())
            ->method('flush');

        $flashBag = $this->createMock(FlashBag::class);
        $session = $this->createMock(Session::class);
        $session->expects($this->once())
            ->method('getFlashBag')
            ->willReturn($flashBag);
        $flashBag->expects($this->once())
            ->method('add');

        return new Reload($em, $session);
    }

    public function testReloadWithNoWeapon()
    {

        $this->expectException(\TypeError::class);

        $loadWeapon = $this->initReloadWeaponError();

        $loadWeapon->reload(null);

    }


    public function testReloadWithWeaponStrange()
    {

        $this->expectException(\TypeError::class);

        $loadWeapon = $this->initReloadWeaponError();

        $loadWeapon->reload("une poule");


    }


    public function testReloadWithWeaponEmpty()
    {

        $weapon = new Weapon();
        $weapon->setAmmunition(0);

        $loadWeapon = $this->initReloadWeapon();

        $loadWeapon->reload($weapon);

        $this->assertEquals($weapon->getAmmunition(), Weapon::MAX_AMMUNITION);

    }

    public function testReloadWithWeaponNegativeAmmunition()
    {

        $weapon = new Weapon();
        $weapon->setAmmunition(-1);

        $loadWeapon = $this->initReloadWeapon();

        $loadWeapon->reload($weapon);

        $this->assertEquals($weapon->getAmmunition(), Weapon::MAX_AMMUNITION);

    }

    public function testReloadWithWeaponOneAmmunition()
    {

        $weapon = new Weapon();
        $weapon->setAmmunition(1);

        $loadWeapon = $this->initReloadWeapon();

        $loadWeapon->reload($weapon);

        $this->assertEquals($weapon->getAmmunition(), Weapon::MAX_AMMUNITION);

    }


    public function testReloadWithWeaponFull()
    {

        $weapon = new Weapon();
        $weapon->setAmmunition($weapon::MAX_AMMUNITION);

        $loadWeapon = $this->initReloadWeapon();

        $loadWeapon->reload($weapon);

        $this->assertEquals($weapon->getAmmunition(), Weapon::MAX_AMMUNITION);

    }

    public function testReloadWithWeaponOneAmmunitionUntilFull()
    {

        $weapon = new Weapon();
        $weapon->setAmmunition($weapon::MAX_AMMUNITION-1);

        $loadWeapon = $this->initReloadWeapon();

        $loadWeapon->reload($weapon);

        $this->assertEquals($weapon->getAmmunition(), Weapon::MAX_AMMUNITION);

    }

    public function testReloadWithWeaponOneAmmunitionBeyondFull()
    {

        $weapon = new Weapon();
        $weapon->setAmmunition($weapon::MAX_AMMUNITION+1);

        $loadWeapon = $this->initReloadWeapon();

        $loadWeapon->reload($weapon);

        $this->assertEquals($weapon->getAmmunition(), Weapon::MAX_AMMUNITION);

    }


}
