<?php

namespace App\Controller\Admin;

use App\Entity\Gift;
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
            ->setController(ReservationCrudController::class)
            ->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Webforce3 Salon');
    }

    public function configureMenuItems(): iterable
    {
        // yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);


        yield MenuItem::subMenu('Massage', 'fas fa-tags')->setSubItems([
            MenuItem::linkToCrud('Liste Massage', 'fa-solid fa-list', Massage::class),
            MenuItem::linkToCrud('Ajout Massage', 'fa-solid fa-paintbrush', Massage::class)->setAction(Crud::PAGE_NEW),
            
        ]);


        yield MenuItem::subMenu('Masseurs', 'fa-solid fa-person')->setSubItems([
            MenuItem::linkToCrud('Liste Masseurs', 'fa-solid fa-list', Massagist::class),
            MenuItem::linkToCrud('Ajout masseurs', 'fa-solid fa-paintbrush', Massagist::class)->setAction(Crud::PAGE_NEW),
            
        ]);

        yield MenuItem::subMenu('Reservation', 'fas fa-store')->setSubItems([
            MenuItem::linkToCrud('Liste Reservation', 'fa-solid fa-list', Reservation::class),          
        ]);

        yield MenuItem::subMenu('Utilisateur', 'fa-solid fa-user-graduate')->setSubItems([
            MenuItem::linkToCrud('Liste Utilisateurs', 'fa-solid fa-list', User::class),
            MenuItem::linkToCrud('Ajout Utilisateur', 'fa-solid fa-paintbrush', User::class)->setAction(Crud::PAGE_NEW),            
        ]);

        yield MenuItem::subMenu('Carte Cadeau', 'fa-solid fa-gift')->setSubItems([
            MenuItem::linkToCrud('Liste Carte Cadeau', 'fa-solid fa-list', Gift::class),            
        ]);

        yield MenuItem::linkToLogout('Logout', 'fa fa-sign-out');
        
    }
    
}
