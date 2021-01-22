<?php

namespace App\EventSubscriber;


use App\Event\AppEvent;
use App\Event\UserEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\AuthenticationEvents;
use Symfony\Component\Security\Http\SecurityEvents;
use Symfony\Component\Security\Core\Event\AuthenticationFailureEvent;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\EventDispatcher\Event;

class UserSubscriber implements EventSubscriberInterface
{

    private $encoder;
    private $entityManager;
    private $token;
    private $session;

    public function __construct(
        UserPasswordEncoderInterface $encoder,
        EntityManagerInterface $entityManager,
        TokenStorageInterface $tokenStorage,
        SessionInterface $session
    ){
        $this->encoder = $encoder;
        $this->entityManager = $entityManager;
        $this->token = $tokenStorage->getToken();
        $this->session = $session;
    }

    public static function getSubscribedEvents()
    {
        return [
            AppEvent::UserEdit => [
                ['userPersist', 0],
                ['userEditPassword', 128],
                ['checkIfZimzim', 256],
            ],
            //celui le plus haut repond avant le plus bas
            AuthenticationEvents::AUTHENTICATION_FAILURE => 'onAuthenticationFailure',
            SecurityEvents::INTERACTIVE_LOGIN => 'onSecurityInteractiveLogin',
        ];
    }

    public function onAuthenticationFailure(AuthenticationFailureEvent $event)
    {
        echo 'failed login ! ';
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
       echo 'login ok ! : '.$event->getAuthenticationToken()->getUser()->getUsername();
    }

    public function checkIfZimzim(UserEvent $event){

        if($event->getUser()->getUsername() === 'zimzim'){
            $event->stopPropagation();
            $this->session->getFlashBag()->add('danger', 'Utilisateur "'.$event->getUser()->getUsername().'"ne peux pas être modifié !');
        }
    }

    public function userPersist(UserEvent $event)
    {
        $this->entityManager->persist($event->getUser());
        $this->entityManager->flush();
    }

    public function userEditPassword(UserEvent $event)
    {
        $event->getUser()->setPassword(
            $this->encoder->encodePassword($event->getUser(), $event->getPassword())
        );
    }
}
