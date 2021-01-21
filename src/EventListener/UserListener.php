<?php

namespace App\EventListener;


use App\Event\ActionEvent;
use App\Event\UserEvent;
use App\Service\Action\ConvertAction;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserListener
{
    private $entityManager;
    private $token;
    private $encoder;
    private $session;

    public function __construct(
        EntityManagerInterface $entityManager,
        TokenStorageInterface $tokenStorage,
        UserPasswordEncoderInterface $encoder,
        SessionInterface $session
    ){
        $this->entityManager = $entityManager;
        $this->token = $tokenStorage->getToken();
        $this->encoder = $encoder;
        $this->session = $session;
    }

    public function encryptPassword(UserEvent $event)
    {
        $event->getUser()->setPassword(
            $this->encoder->encodePassword($event->getUser(), $event->getPassword())
        );
    }

    public function onUserCreate(UserEvent $event)
    {
        $this->entityManager->persist($event->getUser());
        $this->entityManager->flush();
    }

    public function addCallBack(UserEvent $event){
        $this->session->getFlashBag()->add('success', 'Utilisateur "'.$event->getUser()->getUsername().'"a été créé !');
    }
}
