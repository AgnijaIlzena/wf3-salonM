<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
            yield IdField::new(propertyName:'ID')->hideOnForm();
            yield EmailField::new(propertyName: 'email', label: 'Email');
            yield TextField::new(propertyName: 'password', label: 'Mot de passe');
            //yield TextField::new('password')->setFormType(PasswordType::class);
            yield TextField::new(propertyName: 'lastName', label: 'Nom');
            yield TextField::new(propertyName: 'firstName', label: 'Prénom');
            yield ArrayField::new(propertyName: 'roles', label: 'Rôle')->onlyOnForms();
            yield ArrayField::new(propertyName: 'roles[0]', label: 'Rôle')->hideOnForm();
    }
    
}
