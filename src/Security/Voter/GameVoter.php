<?php

namespace App\Security\Voter;

use App\Entity\Game;
use App\Repository\GameUserRepository;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class GameVoter extends Voter
{
    private $security;
    private $gameUserRepository;

    public function __construct(Security $security, GameUserRepository $gameUserRepository)
    {
        $this->security = $security;
        $this->gameUserRepository = $gameUserRepository;
    }

    protected function supports($attribute, $subject)
    {
        if(!in_array($attribute, [AppAccess::GAME_INGAME])){
            return false;
        }
        if(!$subject instanceof Game){
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

        switch($attribute){
            case AppAccess::GAME_INGAME:
                return (null === $this->gameUserRepository->findOneBy(['User' => $user, 'Game' => $subject]) ? false : true );
                break;
        }
    }
}
