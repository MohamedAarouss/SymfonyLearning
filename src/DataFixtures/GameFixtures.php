<?php

namespace App\DataFixtures;

use App\Entity\Game;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GameFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $game = new Game();
        $game->setName("game 1");
        $game->setCreatedAt(new \DateTime('now'));
        $this->addReference($game->getName(), $game);
        $manager->persist($game);

        $game = new Game();
        $game->setName("game 2");
        $game->setCreatedAt(new \DateTime('now'));
        $this->addReference($game->getName(), $game);
        $manager->persist($game);

        $manager->flush();

    }

    private function randIdUser():int
    {
        return \rand(1, 10);
    }
}
