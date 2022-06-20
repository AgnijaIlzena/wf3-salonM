<?php

namespace App\Controller\Admin;

use App\Entity\Massage;
use App\Entity\Massagist;
use App\Entity\Reservation;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;



#[IsGranted('ROLE_ADMIN')]
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
            ->setTitle('Webforce3 Salon');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);


        yield MenuItem::subMenu('Massage', 'fas fa-tags')->setSubItems([
            MenuItem::linkToCrud('Liste Magazine', 'fa-solid fa-list', Massage::class),
            MenuItem::linkToCrud('Create Product', 'fa-solid fa-paintbrush', Massage::class)->setAction(Crud::PAGE_NEW),
            
        ]);


        yield MenuItem::subMenu('Masseurs', 'fa-solid fa-person')->setSubItems([
            MenuItem::linkToCrud('Liste Masseurs', 'fa-solid fa-list', Massagist::class),
            MenuItem::linkToCrud('Ajout masseurs', 'fa-solid fa-paintbrush', Massagist::class)->setAction(Crud::PAGE_NEW),
            
        ]);

        yield MenuItem::subMenu('Reservation', 'fas fa-store')->setSubItems([
            MenuItem::linkToCrud('Liste Reservation', 'fa-solid fa-list', Reservation::class),
            MenuItem::linkToCrud('Ajout Reservation', 'fa-solid fa-paintbrush', Reservation::class)->setAction(Crud::PAGE_NEW),            
        ]);

        yield MenuItem::subMenu('Admin', 'fa-solid fa-user-graduate')->setSubItems([
            MenuItem::linkToCrud('Liste Admin', 'fa-solid fa-list', User::class),
            MenuItem::linkToCrud('Ajout Reservation', 'fa-solid fa-paintbrush', User::class)->setAction(Crud::PAGE_NEW),            
        ]);
    }
    
}
