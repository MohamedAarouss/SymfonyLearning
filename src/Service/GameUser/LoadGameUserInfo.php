<?php

namespace App\Service\GameUser;

use App\Entity\GameUser;
use App\Repository\WeaponRepository;
use Doctrine\ORM\EntityManagerInterface;

class LoadGameUserInfo{

    private $em;
    private $gameUserInfo;
    private $weaponRepository;

    public function __construct(EntityManagerInterface $entityManager, GameUserInfo $gameUserInfo, WeaponRepository $weaponRepository)
    {
        $this->em = $entityManager;
        $this->gameUserInfo = $gameUserInfo;
        $this->weaponRepository = $weaponRepository;
    }


    public function load(GameUser $gameUser): GameUserInfo
    {

        $gameUserInfo = clone($this->gameUserInfo);

        $gameUserInfo->setGameUser($gameUser);
        $gameUserInfo->setWeapons($this->weaponRepository->findBy(['GameUser' => $gameUser]));
        $gameUserInfo->setWeapon($this->weaponRepository->findOneBy(['GameUser' => $gameUser, 'inHand' => true]));

        return $gameUserInfo;
    }
}
