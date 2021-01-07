<?php

namespace App\Service\GameUser;

use App\Entity\GameUser;
use App\Entity\Weapon;

class GameUserInfo{


    private $gameUser;

    /** @var Weapon  */
    private $weapon = null;

    private $weapons = [];

    /**
     * @return GameUser
     */
    public function getGameUser(): GameUser
    {
        return $this->gameUser;
    }

    /**
     * @param GameUser $gameUser
     */
    public function setGameUser(GameUser $gameUser): void
    {
        $this->gameUser = $gameUser;
    }

    /**
     * @return array
     */
    public function getWeapons(): array
    {
        return $this->weapons;
    }

    /**
     * @param array $weapons
     */
    public function setWeapons(array $weapons): void
    {
        $this->weapons = $weapons;
    }

    /**
     * @return Weapon
     */
    public function getWeapon(): ?Weapon
    {
        return $this->weapon;
    }

    /**
     * @param Weapon $weapon
     */
    public function setWeapon(?Weapon $weapon): void
    {
        $this->weapon = $weapon;
    }

    public function getReelDamage(Weapon $weapon): int
    {
        return $weapon->getScarcity() * $weapon->getWeaponType()->getDamage();
    }

    public function IsAmmoEmpty(Weapon $weapon): bool{
        return $weapon->getAmmunition() === 0;
    }

}
