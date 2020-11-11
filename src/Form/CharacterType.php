<?php

namespace App\Form;

use App\Entity\Character;
use App\Form\Type\AgeType;
use App\Form\Type\SexType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CharacterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                null,
                [
                    'attr' => [
                        'placeholder' => 'sarah connord',
                    ],
                ]
            )
            ->add('age', AgeType::class)
            ->add('sex', SexType::class)
            ->add('enabled')
            ->add('createdAt');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Character::class,
            ]
        );
    }
}
