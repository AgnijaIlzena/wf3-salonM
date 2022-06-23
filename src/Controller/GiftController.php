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
        #[Entity('gift', expr: 'repository.find(massage_id)')]
        public function new(GiftRepository $giftRepository, MassageRepository $massageRepository, Massage $massage,  Request $request): Response
        {
        $gift = new Gift();


        $form = $this->createForm(GiftFormType::class, $gift);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $gift->setDate(new DateTimeImmutable());
            $giftRepository->add($gift, true);

            $this->addFlash('succesful', 'Your gift has been added well , time to pay !');

            return $this->redirectToRoute('app_gift');
        }

        return $this->render('gift/gift.html.twig', [
            'form' => $form-> createView(),
            'massage'=>$massage,
        ]);
    }
}