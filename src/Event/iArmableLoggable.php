<?php

namespace App\Event;

use App\Entity\ActionUser;
use App\Entity\Game;
use App\Entity\GameUser;
use App\Entity\Weapon;

interface iArmableLoggable
{

    public function getWeapon(): ?Weapon;
    public function setWeapon(Weapon $weapon): void;

    public function setActionUser(ActionUser $actionUser): void;
    public function getActionUser(): ?ActionUser;

    public function setGameUser(GameUser $gameUser): void;
    public function getGameUser(): ?GameUser;

    public function getAction(): ?string;

}