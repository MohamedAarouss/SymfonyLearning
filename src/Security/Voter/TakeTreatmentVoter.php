<?php

namespace App\Security\Voter;

use App\Entity\TakeTreatment;
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
        if(VoterAccess::TAKE_TREATMENT_EDIT !== $attribute ){
            return false;
        }

        if(!$subject instanceof TakeTreatment){
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

        if ($subject->getStatusDisease()->getUser() === $user && $subject->getFail() === false) {
            return true;
        }

        if($subject->getFail() === true  && $this->security->isGranted("ROLE_MEDECIN") === true){
            return true;
        }

        return false;
    }
}
