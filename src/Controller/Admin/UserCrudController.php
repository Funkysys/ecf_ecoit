<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('email'),
            TextField::new('password')->onlyOnForms()->setFormType(PasswordType::class),
            BooleanField::new('isProfessor')->setPermission('ROLE_ADMIN'),
            ArrayField::new('roles')->setPermission('ROLE_ADMIN'),
            AssociationField::new('professor')->hideOnForm()->setPermission('ROLE_ADMIN'),
            AssociationField::new('student')->hideOnForm()->setPermission('ROLE_ADMIN'),
        ];
    }
}
