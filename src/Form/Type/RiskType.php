<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class RiskType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'choices' => [
                "1/10000" => 10000,
                "1/1000" => 1000,
                "1/50" => 50,
                "1/20" => 20

            ],
            'multiple' => false,
            'expanded' => false,
        ]);
    }


    public function getParent(){
        return ChoiceType::class;
    }
}