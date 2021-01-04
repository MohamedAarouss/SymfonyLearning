<?php

namespace App\Service\Weapon;

use App\Entity\GameUser;
use App\Entity\Weapon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class Reload
{

    private $em;
    private $session;
    private $token;

    public function __construct(EntityManagerInterface $em, SessionInterface $session, TokenStorageInterface $token)
    {
        $this->em = $em;
        $this->session = $session;
        $this->token = $token;
    }

    public function reload(Weapon $weapon)
    {
        $weapon->setAmmunition(Weapon::MAX_AMMUNITION);
        $this->session->getFlashBag()->add('success', $weapon->getName() . ' is reloaded ! beware now i can shoot');
        $this->em->flush();
    }
}

