<?php

namespace App\Controller\Admin;

use App\Entity\Massagist;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

#[IsGranted('ROLE_ADMIN')]
class MassagistCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Massagist::class;
    }

    public function __construct(private string $uploadDir)
    {
        
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new(propertyName:'ID')->hideOnForm();
        yield TextField::new(propertyName:'name', label:'Nom');
        yield TextareaField::new(propertyName:'description', label:'Description');


        yield TextField::new(propertyName: 'file', label: 'Image')
            ->setFormType(formTypeFqcn:VichImageType::class)
            ->onlyOnForms();
        
        yield ImageField::new(propertyName:'cover', label:'Image')
            ->setBasePath(path:$this->uploadDir)
            ->setUploadDir('public/uploads')
            ->hideOnForm();

            
    }
    
    
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setEntityLabelInPlural(label:'Masseurs');
    }
}
