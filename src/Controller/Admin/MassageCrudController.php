<?php

namespace App\Controller\Admin;

use App\Entity\Massage;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

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

        yield IdField::new(propertyName:'ID');
        yield TextField::new(propertyName:'name', label:'Nom');
        yield TextField::new(propertyName:'description', label:'Description');
        yield MoneyField::new(propertyName:'price', label:'Prix')->setCurrency(currencyCode:'EUR');
        yield TextField::new(propertyName: 'file', label: 'Image')
            ->setFormType(formTypeFqcn:VichImageType::class)
            ->onlyOnForms();
        yield ImageField::new(propertyName:'cover', label:'Image')
        ->setBasePath(path:$this->uploadDir);
        // yield AssociationField::new(propertyName:'Massagist', label:'Masseur')
        //     ->setCrudController(crudControllerFqcn: MassagistCrudController::class);

        // return [
        //     'name',
        //     'description',
        //     'price',
        //     'cover',
        // ];
    }

    public function deleteEntity(EntityManagerInterface $em, $entityInstance): void
    {
        if (!$entityInstance instanceof Massage) return;

        foreach ($entityInstance->getMassage() as $massage) {
            $em->remove($massage);
        }

        parent::deleteEntity($em, $entityInstance);
    }
}


