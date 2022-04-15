<?php

namespace App\Controller\Admin;

use App\Entity\Professor;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Provider\AdminContextProvider;

class ProfessorCrudController extends AbstractCrudController
{
    public function __construct(AdminContextProvider $adminContextProvider) {
        $this->adminContextProvider = $adminContextProvider;
    }
    public static function getEntityFqcn(): string
    {
        return Professor::class;
    }

        public function configureFields(string $pageName): iterable
    {

        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('firstname'),
            TextField::new('lastname'),
            TextareaField::new('address'),
            IntegerField::new('experience'),
            TextareaField::new('competences'),
            TextareaField::new('description'),
            AssociationField::new('formations')->autocomplete()->hideOnForm(),
            AssociationField::new('user'),
        ];
    }
}
