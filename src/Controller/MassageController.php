<?php

namespace App\Controller;

use App\Repository\MassageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MassageController extends AbstractController
{
    #[Route('/massage', name: 'app_massage')]
    public function index(MassageRepository $massageRepository): Response
    {
        $massages = $massageRepository->findAll();

        return $this->render('massage/index.html.twig', [
            'massages' => $massages,
        ]);
    }
}
