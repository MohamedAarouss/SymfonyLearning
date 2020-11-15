<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class UserHealthType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        for($i =0; $i < 101 ; $i++){
            $data[$i] = $i;
        }


        $resolver->setDefaults([
            'choices' => $data,
            'multiple' => false,
            'expanded' => false,
        ]);
    }
    public function getParent(){
        return ChoiceType::class;
    }
}
