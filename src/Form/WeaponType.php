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
        $this->weaponType = $options['weapon_type'];
        $this->ammunition = $options['ammunition'];

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
            );
    }

    public function onPreSetData(FormEvent $event)
    {
        $form = $event->getForm();

        /** @var $weapon Weapon */
        $weapon = $event->getData();

        if($weapon->getId() === null){

            if($this->weaponType !== null){
                $weapon->setWeaponType($this->weaponType);
                $form->remove('WeaponType');

                $weapon->setUser($this->tokenStorage->getToken()->getUser());
                $form->remove('User');

                $weapon->setName(
                    $this->weaponType->getName().' de '.$this->tokenStorage->getToken()->getUser()->getUsername()
                );

                $weapon->setAmmunition(Weapon::MAX_AMMUNITION);
                $form->remove('ammunition');

                $weapon->setInHand(false);
                $form->remove('inHand');

            }

        }else{

            if( $this->ammunition === true){
                $form->remove('name')->remove('inHand')->remove('scarcity')->remove('User')->remove('WeaponType');
            }
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Weapon::class,
                'weapon_type' => null,
                'ammunition' => null
            ]
        );
    }
}
