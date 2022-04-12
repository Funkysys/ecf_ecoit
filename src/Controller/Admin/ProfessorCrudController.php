<?php

namespace App\Controller\Admin;

use App\Entity\Professor;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProfessorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Professor::class;
    }

    //public function configureFields(string $pageName): iterable
    //{
        //return [
            //IdField::new('id'),
            //TextField::new('firstname'),
            //TextField::new('lastname'),
            //TextEditorField::new('address'),
            //IntegerField::new('experience'),
            //TextEditorField::new('competences'),
            //TextEditorField::new('description'),
            //TextEditorField::new('formations'),
        //];
    //}
}
