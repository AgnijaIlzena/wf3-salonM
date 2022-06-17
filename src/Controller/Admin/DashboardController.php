<?php

namespace App\Controller\Admin;

use App\Entity\Massage;
use App\Entity\Massagist;
use App\Entity\Reservation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class DashboardController extends AbstractDashboardController
{


    public function __construct(private AdminUrlGenerator $adminUrlGenerator)
    {
        
    }


    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator
            ->setController(MassageCrudController::class)
            ->setController(MassagistCrudController::class)
            ->setController(ReservationCrudController::class)
            ->generateUrl();

        return $this->redirect($url);

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Wf3 SalonM');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);


        yield MenuItem::section('Massage');

        yield MenuItem::subMenu('Massage', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Liste Magazine', 'fas fa-plus', Massage::class),
            MenuItem::linkToCrud('Create Product', 'fas fa-plus', Massage::class)->setAction(Crud::PAGE_NEW),
            
        ]);

        yield MenuItem::section('Masseurs');

        yield MenuItem::subMenu('Masseurs', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Liste Masseurs', 'fas fa-plus', Massagist::class),
            MenuItem::linkToCrud('Ajout masseurs', 'fas fa-plus', Massagist::class)->setAction(Crud::PAGE_NEW),
            
        ]);

        yield MenuItem::section('Masseurs');

        yield MenuItem::subMenu('Masseurs', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Liste Masseurs', 'fas fa-plus', Reservation::class),
            MenuItem::linkToCrud('Ajout masseurs', 'fas fa-plus', Reservation::class)->setAction(Crud::PAGE_NEW),
            
        ]);
    }
    
}
