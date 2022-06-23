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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use DateTimeImmutable;


class GiftController extends AbstractController
{
   
    #[Route('/gift/{id}', name: 'app_gift' , requirements:["id"=>"\d+"]) ]
    public function new(Massage $massage, GiftRepository $giftRepository, Request $request): Response
    {
        $gift = new Gift();

        $form = $this->createForm(GiftFormType::class, $gift);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $gift->setDate(new DateTimeImmutable);
            $gift->setMassage($massage);
            $giftRepository->add($gift, true);

            $this->addFlash('succesful', 'Your gift has been added, time to pay !');

            return $this->redirectToRoute('app_checkout_gift', ['id' => $gift->getId(), 'cadeau' => 'cadeau']);
        }

        return $this->render('gift/gift.html.twig', [
            'form' => $form->createView(),
            'massage'=>$massage,
        ]);
    }
}