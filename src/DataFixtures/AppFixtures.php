<?php

namespace App\DataFixtures;

use App\Entity\Character;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $character = new Character();
        $character->setName('R8')->setAge(5)->setEnabled(true)->setSex('Robot')->setCreatedAt(new \DateTime('now'));
        $manager->persist($character);

        $character = new Character();
        $character->setName('')->setAge(5)->setEnabled(true)->setSex('Robot')->setCreatedAt(new \DateTime('now'));
        $manager->persist($character);

        $manager->flush();
    }
}
