<?php

namespace App\Form\Type;

use App\Entity\Character;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SexType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'choices' => [
                    'Mâle' => Character::MALE,
                    'Femelle' => Character::FEMELLE,
                    'Other' => Character::OTHER,
                    'Robot' => Character::ROBOT,
                ],
                'multiple' => false,
                'expanded' => true,
            ]
        );
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}
