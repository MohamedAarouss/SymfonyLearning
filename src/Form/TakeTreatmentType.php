<?php

namespace App\Form;

use App\Entity\TakeTreatment;
use App\Entity\Treatment;
use App\Form\Type\TreatmentTypeType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class TakeTreatmentType extends AbstractType
{
    private $tokenStorage;
    private $authorizationChecker;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        AuthorizationCheckerInterface $authorizationChecker
    )
    {
        $this->tokenStorage = $tokenStorage;
        $this->authorizationChecker = $authorizationChecker;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('createdAt')
            ->add('content')
            ->add('fail')
            ->add('Traitment', TreatmentTypeType::class)
            ->add('StatusDisease')
            ->add('cancel', SubmitType::class, ['label' => 'Retour a l\'accueil'])
            ->addEventListener(
                FormEvents::PRE_SET_DATA,
                [$this, 'onPreSetData']
            );

        ;
    }

    public function onPreSetData(FormEvent $event)
    {
        $form = $event->getForm(); //récupération du formulaire

        /** @var $entity Treatment */
        $entity = $event->getData(); //récupération de l'entité

        if ($entity->getId() === null) {
            $form->remove('createdAt');
            $form->remove('content');
            $form->remove('fail');
            $form->remove('StatusDisease');
            //$form->add('Traitment', TreatmentTypeType::class);
            $form->add('Traitment', TreatmentTypeType::class,
                ['query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->innerJoin('t.Disease', 'd')
                        ->innerJoin('t.Hospitals', 'h');
//                        ->innerJoin('status_disease', 'sd')
//                        ->innerJoin('user', 'u')
//                        ->where('sd.User = :user')
//                        ->setParameter('user', $this->tokenStorage->getToken()->getUser());
                },]);
            $form->add('submit', SubmitType::class, ['label' => 'Prendre mon traitement']);
        }
        else {
            $form->remove('createdAt');
            $form->remove('fail');
            $form->remove('Traitment');
            $form->remove('StatusDisease');
            $form->add('submit', SubmitType::class, ['label' => 'Editer']);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TakeTreatment::class,
        ]);
    }
}
