<?php

namespace App\Security\Voter;

use App\Entity\GameUser;
use App\Security\Voter\AppAccess;
use App\Entity\User;
use App\Entity\Weapon;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

use Symfony\Component\Security\Core\Security;

class WeaponVoter extends Voter
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject)
    {
        if(!in_array($attribute, [AppAccess::WEAPON_EDIT, AppAccess::WEAPON_SHOW, AppAccess::WEAPON_DELETE])){
            return false;
        }
        if(!$subject instanceof Weapon){
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if(!$user instanceof User){
            return false;
        }

        if(!$subject->getGameUser() instanceof GameUser){
            return true;
        }

        if($this->security->isGranted('ROLE_ADMIN') === true){
            return true;
        }

        switch($attribute){
            case AppAccess::WEAPON_SHOW:
            case AppAccess::WEAPON_EDIT:
            case AppAccess::WEAPON_DELETE:
                return $subject->getGameUser()->getUser()->getId() === $user->getId();
                break;
        }
    }
}
