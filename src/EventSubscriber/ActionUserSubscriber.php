<?php

namespace App\EventSubscriber;


use App\Entity\ActionUser;
use App\Entity\Weapon;
use App\Event\AppEvent;
use App\Event\iArmableLoggable;
use App\Event\UserEvent;
use App\Event\WeaponEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Contracts\Translation\TranslatorInterface;

class ActionUserSubscriber implements EventSubscriberInterface
{

    private $entityManager;
    private $token;
    private $flashBag;
    private $translator;

    public function __construct(
        EntityManagerInterface $entityManager,
        TokenStorageInterface $tokenStorage,
        SessionInterface $session,
        TranslatorInterface $translator
    ){
        $this->entityManager = $entityManager;
        $this->token = $tokenStorage->getToken();
        $this->flashBag = $session->getFlashBag();
        $this->translator = $translator;
    }

    public static function getSubscribedEvents()
    {
        return [
            AppEvent::WeaponReLoad => [
                ['create', 128],
                ['persist', 0],
            ],
            AppEvent::GameUserShoot => [
                ['create', -256],
                ['persist', -512],
            ]
        ];
    }

    public function create(iArmableLoggable $event){

        $actionUser = new ActionUser();
        $actionUser->setCreatedAt(new \DateTime('now'));
        $actionUser->setWeapon($event->getWeapon());
        $actionUser->setGameUser($event->getGameUser());
        $actionUser->setAction($event->getAction());
        $event->setActionUser($actionUser);

    }

    public function persist(iArmableLoggable $event)
    {
        $this->entityManager->persist($event->getActionUser());
        $this->entityManager->flush();
    }

}
