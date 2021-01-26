<?php

namespace App\EventSubscriber;


use App\Entity\Weapon;
use App\Event\AppEvent;
use App\Event\UserEvent;
use App\Event\WeaponEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Contracts\Translation\TranslatorInterface;

class WeaponSubscriber implements EventSubscriberInterface
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
            AppEvent::WeaponLoad => [
                ['unloadAll', 256],
                ['loadUnload', 128],
                ['persist', 0],
                ['addFlashBag', -128],
            ]
        ];
    }

    public function unloadAll(WeaponEvent $event)
    {
        $weapons = $this->entityManager->getRepository(Weapon::class)->findWeaponByUser($this->token->getUser());

        array_map(function ($obj) {
            $obj->setInHand(false);
        }, $weapons);
    }

    public function loadUnload(WeaponEvent $event)
    {
        $event->getWeapon()->setInHand($event->getLoad());
    }

    public function persist(WeaponEvent $event)
    {
        $this->entityManager->persist($event->getWeapon());
        $this->entityManager->flush();
    }

    public function addFlashBag(WeaponEvent $event)
    {
        $this->flashBag->add('success', $this->translator->trans('weapon.load', ['%weapon%' => $event->getWeapon()->getName()]));
    }


}
