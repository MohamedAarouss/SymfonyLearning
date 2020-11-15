<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class ScarcityType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'choices' => [
                "Commun" => 1,
                "Rare" => 2,
                "Epique" => 4,
                "Légendaire" => 8

            ],
            'multiple' => false,
            'expanded' => false,
        ]);
    }


    public function getParent(){
        return ChoiceType::class;
    }
}
