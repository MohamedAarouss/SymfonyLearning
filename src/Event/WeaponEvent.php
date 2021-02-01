<?php

namespace App\Event;

use App\Entity\ActionUser;
use App\Entity\Game;
use App\Entity\GameUser;
use App\Entity\Weapon;
use Symfony\Contracts\EventDispatcher\Event;

class WeaponEvent extends Event implements iArmableLoggable {

    /**
     * @var $action string
     */
    private $action;

    /**
     * @var $actionUser ActionUser
     */
    private $actionUser;

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
     * @var $scarcity boolean
     */
    private $scarcity = false;

    /**
     * @var $load boolean
     */
    private $load;

    /**
     * @var $gameUser GameUser
     */
    private $gameUser;

    public function setGameUser(GameUser $gameUser): void
    {
        $this->gameUser = $gameUser;
    }

    public function getGameUser(): ?GameUser
    {
        return $this->gameUser;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getIdWeaponType(): ?int
    {
        return $this->id_weapon_type;
    }

    /**
     * @param int $id_weapon_type
     */
    public function setIdWeaponType(?int $id_weapon_type): void
    {
        $this->id_weapon_type = $id_weapon_type;
    }

    /**
     * @return int
     */
    public function getIdGame(): ?int
    {
        return $this->id_game;
    }

    /**
     * @param int $id_game
     */
    public function setIdGame(?int $id_game): void
    {
        $this->id_game = $id_game;
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

    /**
     * @return bool
     */
    public function getScarcity(): bool
    {
        return $this->scarcity;
    }

    /**
     * @param bool $scarcity
     */
    public function setScarcity(bool $scarcity): void
    {
        $this->scarcity = $scarcity;
    }

    /**
     * @return bool
     */
    public function getLoad(): bool
    {
        return $this->load;
    }

    /**
     * @param bool $load
     */
    public function setLoad(bool $load): void
    {
        $this->load = $load;
    }

    public function setActionUser(?ActionUser $actionUser): void{
        $this->actionUser = $actionUser;
    }

    public function getActionUser(): ?ActionUser
    {
        return $this->actionUser;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(?string $action){
        return $this->action = $action;
    }

}
