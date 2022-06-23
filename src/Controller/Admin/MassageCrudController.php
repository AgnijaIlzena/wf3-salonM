<?php

namespace App\Controller\Admin;

use App\Entity\Massage;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class MassageCrudController extends AbstractCrudController
{



    public static function getEntityFqcn(): string
    {
        return Massage::class;
    }

    public function configureFields(string $pageName): iterable
    {

        yield IdField::new(propertyName:'id')->hideOnForm();
        yield TextField::new(propertyName:'name', label:'Nom');
        yield TextareaField::new(propertyName:'description', label:'Description');
        yield MoneyField::new(propertyName:'price', label:'Prix')->setCurrency(currencyCode:'EUR');

        yield TextField::new(propertyName: 'profileFile', label: 'Image')
            ->setFormType(formTypeFqcn:VichImageType::class)
            ->onlyOnForms();
            
        yield ImageField::new(propertyName:'cover', label:'Image')
            ->setBasePath('images/')
            ->setUploadDir('public/images')
            ->hideOnForm();

    }

}


