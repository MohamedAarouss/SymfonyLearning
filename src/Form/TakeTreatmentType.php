<?php

namespace App\Form;

use App\Entity\TakeTreatment;
use App\Form\Type\TreatmentTypeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TakeTreatmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('createdAt')
            ->add('content')
            ->add('fail')
            ->add('Traitment', TreatmentTypeType::class)
            ->add('StatusDisease')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TakeTreatment::class,
        ]);
    }
}
