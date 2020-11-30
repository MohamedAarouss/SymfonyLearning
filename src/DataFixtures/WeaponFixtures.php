<?php

namespace App\DataFixtures;

use App\Entity\Weapon;
use App\Entity\WeaponType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class WeaponFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $scarcity = [1,2,4,8];
        for($i = 0; $i < 20; $i++)
        {
            $weapon =  new Weapon();
            $weapon->setWeaponType($this->getReference('weapontype'.\rand(0,4)));
            $weapon->setName($weapon->getWeaponType()->getName().' - '.$weapon->getWeaponType()->getDamage() . ' - ' .$i );
            $weapon->setAmmunition(30);
            $weapon->setScarcity($scarcity[\rand(0,3)]);
            $weapon->setInHand(false);
            $weapon->setGame($this->getReference('game '. \rand(1,2)));
            $this->addReference($weapon->getName(), $weapon);
            $manager->persist($weapon);
        }

        $tabIdsUser =[];
        $scarcity = [1,2,4,8];
        for($i = 1; $i < 11; $i++)
        {
            $weapon =  new Weapon();
            $weapon->setWeaponType($this->getReference('weapontype'.\rand(0,4)));
            $weapon->setGameUser($this->getReference('gameuser'. \rand(1, 25)));
            $weapon->setName($weapon->getWeaponType()->getName().' - '.$weapon->getWeaponType()->getDamage() . ' - ' .$i*100 );
            $weapon->setAmmunition(30);
            $weapon->setScarcity($scarcity[\rand(0,3)]);
            $weapon->setInHand(false);
            $weapon->setGame($this->getReference('game '. \rand(1,2)));
            $this->addReference($weapon->getName(), $weapon);
            $manager->persist($weapon);
        }

        $manager->flush();
    }

    private function randIdUser():int
    {
        return \rand(1,10);
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
            WeaponTypeFixtures::class,
            GameFixtures::class
        );
    }

}
