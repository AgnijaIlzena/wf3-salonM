<?php

namespace App\Controller;
use App\Entity\Gift;
use App\Form\GiftFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\GiftRepository;
use Symfony\Component\HttpFoundation\Request;

class GiftController extends AbstractController
{
    #[Route('/gift', name: 'app_gift')]
   
    public function new( GiftRepository $giftRepository, Request $request): Response
    {
        $gift = new Gift();
       

        $form = $this->createForm(GiftFormType::class, $gift);

        return $this->renderForm('gift/gift.html.twig', [
            'form' => $form,
        ]);
    }
}
