<?php

namespace App\Form;

use App\Entity\GameUser;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class GameUserType extends AbstractType
{
    private $game;
    private $tokenStorage;
    private $authorizationChecker;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        AuthorizationCheckerInterface $authorizationChecker
    ){
        $this->tokenStorage = $tokenStorage; // le token utilisateur
        $this->authorizationChecker = $authorizationChecker; // le service de controle d'utilisateur
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->game = $options['game'];

        $builder
            ->add('health')
            ->add('createdAt')
            ->add('User')
            ->add('Game')
            ->add('submit', SubmitType::class)
            ->addEventListener(
                FormEvents::PRE_SET_DATA,
                [$this, 'onPreSetData']
            );
        ;
    }

    public function onPreSetData(FormEvent $event)
    {
        $form = $event->getForm(); //récupération du formulaire

        /** @var $entity GameUser */
        $entity = $event->getData(); //récupération de l'entité

        if(isset($this->game)){
            $entity->setUser($this->tokenStorage->getToken()->getUser());
            $form->remove('User');
            $entity->setHealth(GameUser::MAX_HEALTH);
            $form->remove('health');
            $entity->setGame($this->game);
            $form->remove('Game');
            $entity->setCreatedAt(new \DateTime('now'));
            $form->remove('createdAt');

            $form->add('submit', SubmitType::class, ['label' => 'm\'inscrire à '.$this->game->getName()]);
        }

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GameUser::class,
            'game' => null
        ]);
    }
}
