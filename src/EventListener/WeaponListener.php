<?php

namespace App\EventListener;


use App\Entity\Game;
use App\Entity\Weapon;
use App\Entity\WeaponType;
use App\Event\ActionEvent;
use App\Event\UserEvent;
use App\Event\WeaponEvent;
use App\Repository\GameRepository;
use App\Repository\WeaponTypeRepository;
use App\Service\Action\ConvertAction;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class WeaponListener
{
    private $entityManager;
    private $weaponTypeRepository;
    private $gameRepository;
    private $session;
    private $validator;

    public function __construct(
        EntityManagerInterface $entityManager,
        GameRepository $gameRepository,
        WeaponTypeRepository $weaponTypeRepository,
        SessionInterface $session,
        ValidatorInterface $validator
    ){
        $this->entityManager = $entityManager;
        $this->weaponTypeRepository = $weaponTypeRepository;
        $this->gameRepository = $gameRepository;
        $this->session = $session;
        $this->validator = $validator;
    }

    public function setName(WeaponEvent $event){
        $event->setWeapon(new Weapon());
        $event->getWeapon()->setName($event->getName());
        $event->getWeapon()->setAmmunition(Weapon::MAX_AMMUNITION);
        $event->getWeapon()->setInHand(false);
    }

    public function onWeaponCreate(WeaponEvent $event)
    {
        $errors = $this->validator->validate($event->getWeapon());

        if(count($errors) === 0) {
            $this->entityManager->persist($event->getWeapon());
            $this->entityManager->flush();
        }
    }

    public function setWeaponType(WeaponEvent $event){

        $weaponType = $this->weaponTypeRepository->find($event->getIdWeaponType());
        if(!$weaponType instanceof WeaponType){
            $event->stopPropagation();
            return;
        }
        $event->getWeapon()->setWeaponType($weaponType);
    }

    public function setGame(WeaponEvent $event){

        $game = $this->gameRepository->find($event->getIdGame());
        if(!$game instanceof Game){
            $event->stopPropagation();
            return;
        }
        $event->getWeapon()->setGame($game);
    }

    public function randScarcity(WeaponEvent $event){
        $scarcity = [1,2, 4, 8];
        $event->getWeapon()->setScarcity($scarcity[\rand(0,3)]);
    }

}
