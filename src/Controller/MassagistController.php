<?php

namespace App\Controller;

use App\Repository\MassagistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MassagistController extends AbstractController
{
    #[Route('/massagist', name: 'app_massagist')]
    public function index(MassagistRepository $massagistRepository): Response
    {
        $massagists = $massagistRepository->findAll();
        return $this->render('massagist/index.html.twig', [
            'massagists' => $massagists
        ]);
    }
}
