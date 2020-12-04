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

    private $weaponType;

    private $ammunition;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        AuthorizationCheckerInterface $authorizationChecker
    ){
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
            ->add('Game')
            ->add('GameUser')
            ->add('WeaponType', \App\Form\Type\WeaponTypeType::class);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Weapon::class,
                'game' => null
            ]
        );
    }
}
