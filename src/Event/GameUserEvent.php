<?php

namespace App\Event;


use App\Entity\ActionUser;
use App\Entity\GameUser;
use App\Entity\Weapon;
use Symfony\Contracts\EventDispatcher\Event;

class GameUserEvent extends Event implements iArmableLoggable {

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
     * @var $gameUser GameUser
     */
    private $gameUser;

    public function getWeapon(): ?Weapon
    {
        return $this->weapon;
    }

    public function setWeapon(Weapon $weapon): void
    {
        $this->weapon = $weapon;
    }

    public function setActionUser(ActionUser $actionUser): void
    {
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
}