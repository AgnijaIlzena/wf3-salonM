<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\CalendarService;
use App\Service\TimeSlotsService;

class ReservationController extends AbstractController
{   
    // ajouter ID du massage en dans l'url
    #[Route('/reservation', name: 'app_reservation')]
    public function index(CalendarService $calendarService, TimeSlotsService $timeSlotsService): Response
    {   
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

        $duration = 60;
        // cleanUp = temps entre 2 rendez-vous
        $cleanUp = 0;
        $start = "09:00";
        $end = "18:00";

        $timeSlots = $timeSlotsService->timeslots($duration, $cleanUp, $start, $end);
        
        return $this->render('reservation/index.html.twig',[
            'calendar'=>$calendar,
            'timeSlots'=>$timeSlots
        ]);
    }
}
