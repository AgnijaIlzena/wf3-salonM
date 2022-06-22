<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\CalendarService;
use App\Service\TimeSlotsService;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ReservationRepository;
use App\Form\ReservationFormType;
use App\Entity\Reservation;
use App\Entity\Massage;
use App\Repository\MassagistRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\MassageRepository;
use App\Controller\PDO;

class ReservationController extends AbstractController
{   
    #[Route('/reservation/{id}', name: 'app_reservation', requirements:["id"=>"\d+"])]
    #[Entity('reservation', expr: 'repository.find(massage_id)')]
    public function index(
        Massage $massage,
        CalendarService $calendarService, 
        TimeSlotsService $timeSlotsService, 
        ReservationRepository $reservationRepository,
        MassagistRepository $massagistRepository
        
        ): Response
    {   
        // Affichage des masseurs
        $massagists = $massagistRepository->findAll();

        // Affichage calendrier
        // $reservationRepository->findBy(['date' => DateTime::createFromFormat('Y-m-d','2022-06-08 08:23:41')]);
        $dateComponents = getdate();
        if(isset($_GET['month']) && isset($_GET['year'])){
           $month = +$_GET['month'];
           $year = $_GET['year'];
        }
        else{
           $month = $dateComponents['mon'];
           $year = $dateComponents['year'];
        }
        // $totalBookings = count($reservationRepository->findBy(['date'=>$year.'-'.$month.'-24']));
        $calendar =  $calendarService->build_calendar($month , $year, $reservationRepository);

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

        
        return $this->render('reservation/index.html.twig',[
            'calendar'=>$calendar,
            'timeSlots'=>$timeSlots,
            'massagists'=>$massagists,
            'massage'=>$massage,
            'form'=>$form->createView()
        ]);
    }


    #[Route('/payement/{id}', name: 'payement', requirements:['id'=>'\d+'])]
    public function test(Reservation $reservation){   
        return $this->render('reservation/test.html.twig',[
            'reservation'=>$reservation]
    );
    }
}
