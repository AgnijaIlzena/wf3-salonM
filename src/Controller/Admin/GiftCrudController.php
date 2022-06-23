<?php

namespace App\Controller\Admin;

use App\Entity\Gift;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;

class GiftCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Gift::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new(propertyName:'id')->hideOnForm();
        yield TextField::new(propertyName: 'sender', label: 'Expéditeur');
        yield TextField::new(propertyName: 'sender_email', label: 'Adresse mail Expéditeur');
        yield TextField::new(propertyName: 'receiver', label: 'Destinataire');
        yield TextField::new(propertyName: 'receiver_email', label: 'Adresse mail Destinataire');
        yield AssociationField::new(propertyName:'massage', label:'Massage')
            ->setCrudController(crudControllerFqcn: MassageCrudController::class);
        yield TextField::new(propertyName: 'message', label: 'Message');
        yield TextField::new(propertyName:'Validation', label: 'Validation')->hideOnForm(); 
    
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural(label:'Carte Cadeau');
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::NEW);
    }

    
}
