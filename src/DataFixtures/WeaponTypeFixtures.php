<?php

namespace App\DataFixtures;

use App\Entity\WeaponType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class WeaponTypeFixtures extends Fixture
{
    CONST TYPE = [['SNIPER', 100], ['FUSIL D\'ASSAULT', 60], ['MITRALLIEUSE', 40], ['PISTOLET', 20], ['REVOLVER', 50]];


    public function load(ObjectManager $manager)
    {

        foreach(WeaponTypeFixtures::TYPE as $key => $weapon){

            $weaponType =  new WeaponType();
            $weaponType->setName($weapon[0]);
            $weaponType->setDamage($weapon[1]);
            $this->addReference('weapontype'.$key, $weaponType);
            $manager->persist($weaponType);
        }

        $manager->flush();
    }
}
