<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\Type\RolesType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureFields(string $pageName): iterable
    {

        $fields = [];

        array_push(
            $fields,
            IdField::new('id')
                ->hideOnForm()
        );

        if (Crud::PAGE_NEW === $pageName || Crud::PAGE_INDEX === $pageName) {
            array_push(
                $fields,
                TextField::new('username'),
                TextField::new('password')
                    ->hideOnIndex(),
                TextEditorField::new('content')
            );
        }


        if (Crud::PAGE_EDIT === $pageName) {
            array_push(
                $fields,
                ArrayField::new('roles')
                ->setFormType(RolesType::class),
                TextEditorField::new('content')
            );
        };

        return $fields;
    }

}
