<?php

namespace App\Controller\Admin;

use App\Entity\Reservation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

#[IsGranted('ROLE_ADMIN')]
class ReservationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reservation::class;
    }

    
    public function configureFields(string $pageName): iterable
    {

            yield IdField::new(propertyName:'ID')->hideOnForm();
            yield DateField::new(propertyName: 'date', label: 'Date');
            yield EmailField::new(propertyName: 'email', label: 'Email');
            yield TextField::new(propertyName: 'lastname', label: 'Nom');
            yield TextField::new(propertyName: 'firstname', label: 'Prénom');
            yield TelephoneField::new(propertyName: 'telephone', label: 'Téléphone');

            yield AssociationField::new(propertyName:'massagist', label:'Masseur')
                ->setCrudController(crudControllerFqcn: MassagistCrudController::class);

            yield AssociationField::new(propertyName:'massage', label:'Massage')
                ->setCrudController(crudControllerFqcn: MassageCrudController::class);
            
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::NEW)
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setEntityLabelInPlural(label:'Réservation');
    }

    
}
