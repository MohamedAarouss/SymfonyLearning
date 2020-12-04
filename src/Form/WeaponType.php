<?php

namespace App\Form;

use App\Entity\Weapon;
use App\Form\Type\AmmunitionType;
use App\Form\Type\ScarcityType;
use App\Repository\GameUserRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
    private $gameUserRepository;

    private $game;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        AuthorizationCheckerInterface $authorizationChecker,
        GameUserRepository $gameUserRepository
    ){
        $this->tokenStorage = $tokenStorage;
        $this->authorizationChecker = $authorizationChecker;
        $this->gameUserRepository = $gameUserRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->game = $options['game'];

        $builder
            ->add('name')
            ->add('ammunition', AmmunitionType::class)
            ->add('inHand')
            ->add('scarcity', ScarcityType::class)
            ->add('Game')
            ->add('GameUser')
            ->add('WeaponType', \App\Form\Type\WeaponTypeType::class)
            ->add('submit', SubmitType::class, ['label' => 'Ajouter'])
            ->addEventListener(
                FormEvents::PRE_SET_DATA,
                [$this, 'onPreSetData']
            );
    }

    public function onPreSetData(FormEvent $event)
    {
        $form = $event->getForm(); //récupération du formulaire

        /** @var $entity Weapon */
        $entity = $event->getData(); //récupération de l'entité


        if($this->game !== null){

            if($entity->getId() === null){
                $entity->setGameUser(
                    $this->gameUserRepository->findOneBy(
                        ['Game' => $this->game, 'User' => $this->tokenStorage->getToken()->getUser()]
                    )
                );
                $form->remove('GameUser');
                $entity->setGame($this->game);
                $form->remove('Game');
                $entity->setAmmunition(Weapon::MAX_AMMUNITION);
                $form->remove('ammunition');
                $entity->setName($this->game->getName().' '.$this->tokenStorage->getToken()->getUser()->getUsername());
                $entity->setInHand(false);
                $form->remove('inHand');
            } else{
                $form->remove('Game');
                $form->add(
                    'GameUser',
                    null,
                    [
                        'query_builder' => function (EntityRepository $er){
                            return $er->createQueryBuilder('gu')
                                ->where('gu.Game = :game')
                                ->setParameter('game', $this->game)
                                ->orderBy('gu.User', 'ASC');
                        },
                    ]
                );
            }

        }

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Weapon::class,
                'game' => null,
            ]
        );
    }
}
