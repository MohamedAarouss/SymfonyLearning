<?php

namespace App\DataFixtures;

use App\Entity\GameUser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class GameUserFixtures extends Fixture implements DependentFixtureInterface
{

    private $users = [];

    public function load(ObjectManager $manager)
    {
        for($i =1; $i < 30; $i++){

            if($i==19){
                $this->users = [];
            }
            $gameUser = new GameUser();
            $gameUser->setCreatedAt(new \DateTime('now'));
            $gameUser->setHealth(GameUser::MAX_HEALTH);
            if($i < 19){
                $gameUser->setGame($this->getReference('game 1'));
            } else{
                $gameUser->setGame($this->getReference('game 2'));
            }
            $gameUser->setUser($this->getReference('user'.$this->getUser()));
            $this->addReference('gameuser'.$i, $gameUser);
            $manager->persist($gameUser);
        }

        $manager->flush();

    }


    private function getUser(){
        $find = false;
        $idUser = 0;
        while($find === false){
            $idUser = \rand(1,20);
            if(!in_array($idUser, $this->users)){
                $this->users[] = $idUser;
                $find = true;
            }
        }
        return $idUser;
    }


    public function getDependencies()
    {
        return array(
            UserFixtures::class,
            GameFixtures::class
        );
    }

}
