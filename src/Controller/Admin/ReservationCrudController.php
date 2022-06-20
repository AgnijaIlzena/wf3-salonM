<?php

namespace App\Controller\Admin;

use App\Entity\Reservation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

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
            yield TextField::new(propertyName: 'telephone', label: 'Téléphone');
    }
    
}
