<?php

namespace App\Controller\Admin;

use App\Entity\Massage;
use Doctrine\ORM\EntityManagerInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use App\Controller\Admin\MassagistCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class MassageCrudController extends AbstractCrudController
{

    public function __construct(private string $uploadDir)
    {
        
    }

    public static function getEntityFqcn(): string
    {
        return Massage::class;
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
    public function configureFields(string $pageName): iterable
    {

        yield IdField::new(propertyName:'ID')->hideOnForm();;
        yield TextField::new(propertyName:'name', label:'Nom');
        yield TextareaField::new(propertyName:'description', label:'Description');
        yield MoneyField::new(propertyName:'price', label:'Prix')->setCurrency(currencyCode:'EUR');

        yield TextField::new(propertyName: 'file', label: 'Image')
            ->setFormType(formTypeFqcn:VichImageType::class)
            ->onlyOnForms();
            
        yield ImageField::new(propertyName:'cover', label:'Image')
        ->setBasePath(path:$this->uploadDir)
        ->setUploadDir('public/uploads')
        ->hideOnForm();



        
        // yield AssociationField::new(propertyName:'Massagist', label:'Masseur')
        //     ->setCrudController(crudControllerFqcn: MassagistCrudController::class);

        // return [
        //     'name',
        //     'description',
        //     'price',
        //     'cover',
        // ];
    }


}


