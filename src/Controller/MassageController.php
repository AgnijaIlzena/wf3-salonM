<?php

namespace App\Controller;


use App\Entity\Massage;

use App\Repository\MassageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;


class MassageController extends AbstractController
{

    #[Route('/massage', name: 'app_massage')]


    #[Route('/massage/delete/{id}', name:'delmassage', requirements: ['id' => '\d+'])]
    public function deleteMassage(Massage $massage, Request $request, MassageRepository $massageRepository): RedirectResponse
    {

        $tokenCsrf = $request->request->get('token');

        if ($this->isCsrfTokenValid('delete-massage-'. $massage->getId(), $tokenCsrf))
        {
            $massageRepository->remove($massage, true);
            $this->addFlash('success', 'Le massage à bien été supprimée'); 
        }

        return $this->redirectToRoute('admin');
    }
    
    public function index(MassageRepository $massageRepository): Response
    {
        $massages = $massageRepository->findAll();

        return $this->render('massage/index.html.twig', [
            'massages' => $massages,
        ]);
    }

}
