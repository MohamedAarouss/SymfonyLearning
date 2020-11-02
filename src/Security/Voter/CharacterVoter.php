<?php

namespace App\Security\Voter;

use App\Entity\Character;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class CharacterVoter extends Voter
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject)
    {
        if(VoterAccess::CHARACTER_SHOW !== $attribute ){
            return false;
        }

        if(!$subject instanceof Character){
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if(!$user instanceof User){
            return false;
        }

        if($this->security->isGranted('ROLE_ADMIN') === false){
            return false;
        }

        if($this->security->isGranted('ROLE_SUPER_ADMIN') === true){
            return true;
        }

        switch($attribute){
            case VoterAccess::CHARACTER_SHOW:
                return ($subject->getAge() <  25 ? false : true );
        }
    }
}
