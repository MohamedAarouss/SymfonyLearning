<?php

namespace App\Form\Type;

use App\Entity\WeaponType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class WeaponTypeType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults([
            'class' => WeaponType::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('wp')
                    ->orderBy('wp.name', 'DESC');
            },
            'choice_label' => 'name',
            'compound' => false,
            'multiple' => false,
        ]);
    }


    public function getParent(){
        return EntityType::class;
    }
}
