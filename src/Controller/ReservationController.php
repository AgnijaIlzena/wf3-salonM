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
use App\Repository\MassagistRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\MassageRepository;


class ReservationController extends AbstractController
{   
    #[Route('/reservation/{id}', name: 'app_reservation', requirements:["id"=>"\d+"])]
    #[Entity('reservation', expr: 'repository.find(massage_id)')]
    public function index(
        Massage $massage,
        CalendarService $calendarService, 
        TimeSlotsService $timeSlotsService, 
        ReservationRepository $reservationRepository,
        MassagistRepository $massagistRepository,
        Request $request
        
        ): Response
    {   
        // Affichage des masseurs
        $massagists = $massagistRepository->findAll();

        // Affichage calendrier
        // $reservationRepository->findBy(['date' => DateTime::createFromFormat('Y-m-d','2022-06-08 08:23:41')]);
        $dateComponents = getdate();
        if(isset($_GET['month']) && isset($_GET['year'])){
           $month = +$request->query->get('month');
           $year = $request->query->get('year');
        }
        else{
           $month = $dateComponents['mon'];
           $year = $dateComponents['year'];
        }
        
        $massagist = $request->query->get('massagist');
        dump($massagist);
        $calendar =  $calendarService->build_calendar($month , $year, $reservationRepository, $massagist);

        // Affichage des créneaux horaires
        $duration = 60;
        // cleanUp = temps entre 2 rendez-vous
        $cleanUp = 0;
        $start = "09:00";
        $end = "18:00";

        // date récupérée dans l'url au clic sur un jour du calendrier
        $date = $request->query->get('date');

        // créneaux réservés en bdd
        $timeSlotsBooked = $reservationRepository->findTimeSlotByDate($date);
        $timeSlotsBookedClean=[];
        foreach ($timeSlotsBooked as $ts) {
            $timeSlotsBookedClean[]=$ts['timeslot'];
        }
   
        // tous les créneaux disponibles 
        $timeSlotsArray = $timeSlotsService->timeslots($duration, $cleanUp, $start, $end);
        
        // Filtrer les résultats pour garder seulement les créneaux horaires disponibles
        if(!empty($timeSlotsBookedClean)){
            $timeSlotsFiltered = array_diff($timeSlotsArray, $timeSlotsBookedClean);
        }
        else{
            $timeSlotsFiltered = $timeSlotsArray;
        }


        //  formulaire
        $reservation = new Reservation();
        $form = $this->createForm(ReservationFormType::class, $reservation);

        
        return $this->render('reservation/index.html.twig',[
            'calendar'=>$calendar,
            'timeSlots'=>$timeSlotsFiltered,
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

    #[Route('/reservation', name: 'app_reservation_datas', methods: ['POST'])]
    public function setData(
        ReservationRepository $reservationRepository,
        MassageRepository $massageRepository,
        MassagistRepository $massagistRepository,
        Request $request,
        ):JsonResponse
    {   
        $data = json_decode($request->getContent(), true);
        
        $reservation = new Reservation();

        $massageId = $massageRepository->find($data['massageId']);
        $reservation->setMassage($massageId);

        $massagist = $massagistRepository->find($data['massagistId']);
        $reservation->setMassagist($massagist);

        $reservation->setDate($data['date']);

        $reservation->setTimeslot($data['timeslot']);

        $reservation->setLastname($data['lastname']);

        $reservation->setFirstname($data['firstname']);

        $reservation->setEmail($data['email']);

        $reservation->setTelephone($data['telephone']);

        $reservationRepository->add($reservation, true);

        return $this->json($reservation->getId());
    }

}
