<?php

namespace App\Controller\Admin;

use App\Entity\Massagist;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MassagistCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Massagist::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
    
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setEntityLabelInPlural(label:'Masseurs');
    }
}
