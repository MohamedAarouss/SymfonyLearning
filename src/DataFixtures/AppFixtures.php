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
        $character->setName('BB8')->setAge(5)->setEnabled(true)->setSex(Character::ROBOT)->setCreatedAt(new \DateTime('now'));
        $manager->persist($character);

        $character = new Character();
        $character->setName('Lara')->setAge(25)->setEnabled(true)->setSex(Character::FEMELLE)->setCreatedAt(new \DateTime('now'));
        $manager->persist($character);

        $character = new Character();
        $character->setName('Gandalf')->setAge(152)->setEnabled(true)->setSex(Character::MALE)->setCreatedAt(new \DateTime('now'));
        $manager->persist($character);

        $character = new Character();
        $character->setName('Tony')->setAge(32)->setEnabled(true)->setSex(Character::MALE)->setCreatedAt(new \DateTime('now'));
        $manager->persist($character);

        $character = new Character();
        $character->setName('Winnie')->setAge(12)->setEnabled(true)->setSex(Character::OTHER)->setCreatedAt(new \DateTime('now'));
        $manager->persist($character);

        $manager->flush();
    }
}
