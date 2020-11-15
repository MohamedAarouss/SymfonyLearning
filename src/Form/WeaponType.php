<?php

namespace App\Form;

use App\Entity\Weapon;
use App\Form\Type\AmmunitionType;
use App\Form\Type\ScarcityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;


class WeaponType extends AbstractType
{
    private $tokenStorage;
    private $authorizationChecker;

    public function __construct(TokenStorageInterface $tokenStorage, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->tokenStorage = $tokenStorage;
        $this->authorizationChecker = $authorizationChecker;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('ammunition', AmmunitionType::class)
            ->add('inHand')
            ->add('scarcity', ScarcityType::class)
            ->add('User')
            ->add('WeaponType')
            ->addEventListener(
                FormEvents::PRE_SET_DATA,
                [$this, 'onPreSetData']
            )
        ;
    }

    public function onPreSetData(FormEvent $event)
    {
        $form = $event->getForm();

        /** @var $weapon Weapon */
        $weapon = $event->getData();

        if($this->authorizationChecker->isGranted('ROLE_ADMIN') === false){
            $form->remove('inHand');
            $weapon->setInHand(false);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Weapon::class,
        ]);
    }
}
