<?php

namespace App\Form;

use App\Entity\User;
use App\Form\Type\RolesType;
use App\Form\Type\UserHealthType;
use App\Form\Type\BooBoolType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;


class UserType extends AbstractType
{
    private $tokenStorage;
    private $authorizationChecker;

    private $usernameDefault;

    public function __construct(TokenStorageInterface $tokenStorage, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->tokenStorage = $tokenStorage; // le token utilisateur
        $this->authorizationChecker = $authorizationChecker; // le service de controle d'utilisateur
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->usernameDefault = $options['usernameDefault'];

        $builder
            ->add('username')
            ->add('roles', RolesType::class)
            ->add('health', UserHealthType::class)
            ->add('createdAt')
            ->add('plainPassword', PasswordType::class, ['mapped' => false, 'required' => false] )
            ->addEventListener(
                FormEvents::PRE_SET_DATA,
                [$this, 'onPreSetData']
            )
        ;
    }

    public function onPreSetData(FormEvent $event)
    {
        $form = $event->getForm(); //récupération du formulaire

        /** @var $entity User */
        $entity = $event->getData(); //récupération de l'entité

        if($this->authorizationChecker->isGranted('ROLE_ADMIN') === false)// Check les roles
        {
            $form->remove('plainPassword');
        }

        if($entity->getUsername() === $this->tokenStorage->getToken()->getUser()->getUsername()) //recupere l'utilisateur et check si c'est celui du formulaire
        {
            $form->remove('username');
        }

        if($entity->getId() === null)//si je suis en création
        {
            $entity->setUsername($this->usernameDefault);

            $form->remove('health');
            $form->remove('createdAt');
            $entity->setHealth(50);
            $entity->setCreatedAt(new \DateTime('now'));
        }else//si je suis en édition
        {
            $form->add('changePassword',PasswordType::class, ['mapped' => false, 'required' => false]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'usernameDefault' => null
        ]);
    }
}
