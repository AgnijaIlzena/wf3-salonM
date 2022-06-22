<?php

namespace App\Controller;

use App\Entity\Gift;
use App\Entity\User;
use App\Entity\Massage;
use App\Form\GiftFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\GiftRepository;
use App\Repository\UserRepository;
use App\Repository\MassageRepository;
use Symfony\Component\HttpFoundation\Request;


class GiftController extends AbstractController
{
   
        #[Route('/gift', name: 'app_gift')]
        public function new(GiftRepository $giftRepository, MassageRepository $massageRepository,  Request $request): Response
        {
        $gift = new Gift();


        $form = $this->createForm(GiftFormType::class, $gift);

        return $this->renderForm('gift/gift.html.twig', [
            'form' => $form,
            'massages' => $massageRepository->findAll()
        ]);
    }
}