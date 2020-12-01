<?php

namespace App\Service\Weapon;

use App\Entity\GameUser;
use App\Entity\Weapon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class Load
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

    public function load(Weapon $weapon)
    {
        $weapons = $this->em->getRepository(Weapon::class)->findWeaponByUser($this->token->getToken()->getUser());

        array_map(function ($obj) {
            $obj->setInHand(false);
        }, $weapons);

        $weapon->setInHand(true);
        $this->session->getFlashBag()->add('success', $weapon->getName() . ' is loaded ! beware of the bang bang');
        $this->em->flush();
    }
}

