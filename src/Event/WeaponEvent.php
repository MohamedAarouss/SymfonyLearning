<?php

namespace App\Event;

use App\Entity\User;
use App\Entity\Weapon;
use Symfony\Contracts\EventDispatcher\Event;

class WeaponEvent extends Event{


    /**
     * @var $weapon Weapon
     */
    private $weapon;

    /**
     * @var $name string
     */
    private $name;

    /**
     * @var $name integer
     */
    private $id_weapon_type;

    /**
     * @var $name integer
     */
    private $id_game;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getIdWeaponType(): int
    {
        return $this->id_weapon_type;
    }

    /**
     * @param int $id_weapon_type
     */
    public function setIdWeaponType(int $id_weapon_type): void
    {
        $this->id_weapon_type = $id_weapon_type;
    }

    /**
     * @return int
     */
    public function getIdGame(): int
    {
        return $this->id_game;
    }

    /**
     * @param int $id_game
     */
    public function setIdGame(int $id_game): void
    {
        $this->id_game = $id_game;
    }

    /**
     * @return Weapon
     */
    public function getWeapon(): Weapon
    {
        return $this->weapon;
    }

    /**
     * @param Weapon $weapon
     */
    public function setWeapon(Weapon $weapon): void
    {
        $this->weapon = $weapon;
    }

}
