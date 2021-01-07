<?php

namespace App\Service\GameUser;


use App\Entity\GameUser;
use App\Entity\Weapon;
use App\Repository\WeaponRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class Shoot
{

    private $em;
    private $weaponRepository;
    private $session;
    private $token;
    private $gameUserInfo;

    public function __construct(
        EntityManagerInterface $entityManager,
        WeaponRepository $weaponRepository,
        SessionInterface $session,
        TokenStorageInterface $token,
        GameUserInfo $gameUserInfo
    ){
        $this->em = $entityManager;
        $this->weaponRepository = $weaponRepository;
        $this->session = $session;
        $this->token = $token;
        $this->gameUserInfo = $gameUserInfo;
    }

    public function shootGameUser(GameUser $gameUser)
    {
        $weapon = $this->weaponRepository->findWeaponByUserInHand($this->token->getToken()->getUser(), true);

        if($weapon instanceof Weapon){

            if($this->gameUserInfo->IsAmmoEmpty($weapon) === false){

                $damage = $this->gameUserInfo->getReelDamage($weapon);

                $gameUser->setHealth($gameUser->getHealth() - $damage);

                $weapon->setAmmunition($weapon->getAmmunition() - 1);

                $this->session->getFlashBag()->add(
                    'success',
                    'Poumm dans ta face '.$gameUser->getUser()->getUsername()
                );

                $this->em->flush();

            }else{
                $this->session->getFlashBag()->add('danger', 'Poum poum ... ah zut j\'ai plus de munition !');
            }
        }else{
            $this->session->getFlashBag()->add('danger', 'Poum poum ... ah zut j\'ai pas d\'arme dans la main !');
        }
    }

}
