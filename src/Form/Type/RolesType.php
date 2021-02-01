<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class RolesType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'choices' => [
                'ROLE_USER' => 'ROLE_USER',
                'ROLE_ADMIN' => 'ROLE_ADMIN',
                'ROLE_SUPER_ADMIN' => 'ROLE_SUPER_ADMIN',
            ],
            'multiple' => true,
            'expanded' => true,
            'allow_add' => null,
            'allow_delete' => null,
            'delete_empty' => null,
            'entry_options' => null,
            'entry_type' => null,
        ]);
    }
    public function getParent(){
        return ChoiceType::class;
    }
}
