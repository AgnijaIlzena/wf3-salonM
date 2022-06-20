<?php

namespace App\Controller;

use App\Entity\Massage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\CalendarService;
use App\Service\TimeSlotsService;

use Symfony\Component\HttpFoundation\Request;
use App\Repository\ReservationRepository;
use App\Form\ReservationFormType;
use App\Entity\Reservation;
use App\Repository\MassagistRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\MassageRepository;


class ReservationController extends AbstractController
{   
    // ajouter ID du massage en dans l'url

    #[Route('/reservation/{id}', name: 'app_reservation', requirements:["id"=>"\d+"])]

    public function index(
        CalendarService $calendarService, 
        TimeSlotsService $timeSlotsService, 
        Request $request,
        ReservationRepository $reservationRepository,
        MassagistRepository $massagistRepository,

        Massage $massage,
        MassageRepository $massageRepository,
       
        
        ): Response
    {   
        // Affichage des masseurs
        $massagists = $massagistRepository->findAll();

        // Affichage calendrier
        $dateComponents = getdate();
        if(isset($_GET['month']) && isset($_GET['year'])){
           $month = +$_GET['month'];
           $year = $_GET['year'];
        }
        else{
           $month = $dateComponents['mon'];
           $year = $dateComponents['year'];
        }
        $calendar =  $calendarService->build_calendar($month , $year);

        // Affichage timeslots
        $duration = 60;
        // cleanUp = temps entre 2 rendez-vous
        $cleanUp = 0;
        $start = "09:00";
        $end = "18:00";

        $timeSlots = $timeSlotsService->timeslots($duration, $cleanUp, $start, $end);


        //  on déclare un objet vide, que l'on remplira par la suite
        $reservation = new Reservation();
        $form = $this->createForm(ReservationFormType::class, $reservation);

        // rempli $reservation avec les données du formulaire
        $form->handleRequest($request);

        // si le formulaire est envoyé et qu'il est correct on enregistre les données dans la bdd
        if($form->isSubmitted()&& $form->isValid()){
            $reservationRepository->add($reservation, true);
        
        // !!!!!!!!!! route à créer
        // redirige vers une autre route
        return $this->redirectToRoute('paiement');
        }

        
        return $this->render('reservation/index.html.twig',[
            'calendar'=>$calendar,
            'timeSlots'=>$timeSlots,
            'massagists'=>$massagists,
            'massage'=>$massage,
            'form'=>$form->createView()
        ]);
    }

    #[Route('/massagist/{massagistId}', name: 'app_reservation_datas', methods: ['POST'])]
    public function setData(
        $massagistId ,
        Reservation $reservation,
        ReservationRepository $reservationRepository):JsonResponse
    {
        // ajax, set massagist_id
        $reservation->setMassagist($massagistId);
        $reservationRepository->add($reservation, true);

        return $this->json(['role' => $reservation]);
    }
}
