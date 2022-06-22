<?php
namespace App\Service;
// use mysqli;


class CalendarService{
    // function checkSlots($mysqli, $date){
    //     $stmt = $mysqli->prepare('SELECT * FROM bookings WHERE date=?');
    //     $stmt->bind_param('s',$date);
    //     $totalBookings = 0;
    //     if($stmt->execute()){
    //         $result = $stmt->get_result();
    //         if($result->num_rows>0){
    //             while($row = $result->fetch_assoc()){
    //                 $totalBookings++;
    //             }
    //             $stmt->close();
    //         }
    //     }
    //     return $totalBookings;
    // }
    function build_calendar($month, $year, $reservationRepository){

        // $mysqli = new mysqli('localhost','root','','salon');
        
    
        $daysOfWeek = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'];
        $daysOfMonth = [1=>'Janvier','Février','Mars','Avril','Mai','Juin',
        'Juillet','Août','Septembre','Octobre','Novembre','Décembre'];
    
        // premier jour du mois renseigné en argument
        // mktime get unix timestamp,  mktime(hour,min,sec,month,day,year);
        $firstDayOfMonth = mktime(0,0,0,$month,1,$year);
    
        // nombre de jours contenus dans ce mois
        $numberOfDays = date('t',$firstDayOfMonth);
    
        // getdate() retourne un tableau avec les sec, min, jour, etc.
        $dateComponents = getdate($firstDayOfMonth);
    
        // nom du mois
        $monthName = $daysOfMonth[$month];
    
        // mois précédent
        $prev_month = date('m',mktime(0,0,0,$month-1,1,$year));
        // prev_year = année du mois précédent
        $prev_year = date('Y',mktime(0,0,0,$month-1,1,$year));
        $next_month = date('m',mktime(0,0,0,$month+1,1,$year));
        $next_year = date('Y',mktime(0,0,0,$month+1,1,$year));
    
    
        // jour de la semaine du premier jour du mois - nb de 0 à 6
        // -1 pour commencer par lundi - par défaut dimanche = 0, lun = 1, etc.
        $dayOfWeek = $dateComponents['wday']-1;
        // si le 1er jour du mois est un dimanche -> transformer -1 en 6 
        if($dayOfWeek ==-1){
            $dayOfWeek = 6;
        }
    
        // tableau html pour créer le calendrier
        $calendar = "<table class = 'table table-bordered'>";
        $calendar.="<div class ='text-center'><h2>$monthName $year</h2></div>";
        $calendar.= "<div class='buttons d-flex justify-content-between w-50 mx-auto my-3'>
                    <a class='btn btn-primary btn-xs' href='?month=$prev_month&year=$prev_year' >Mois précédent</a>";
        $calendar.= "<a class='btn btn-primary btn-xs' href='?month=".date('m')."&year=".date('Y')."' >Mois en cours</a></center>";
        $calendar.= "<a class='btn btn-primary btn-xs' href='?month=$next_month&year=$next_year' >Mois suivant</a>
                    </div>";
        $calendar.= "<thead><tr>";
    
        // affichage des jours de la semaine en tête de colonnes
        foreach ($daysOfWeek as $day){
            $calendar.="<th class='header'>$day</th>";
        }
    
        $calendar.= "</tr></thead><tbody><tr>";
        // cases vides au début du mois si celui-ci ne comence pas par lundi
        if($dayOfWeek > 0){
            for ($i=0; $i < $dayOfWeek ; $i++) { 
                $calendar.="<td></td>";
            }
        }
        $currentDay = 1;
        // fct php qui place un 0 à gauche du chiffre si 1 chiffre, ex: 06, 12 reste 12
        $month = str_pad($month, 2, '0', STR_PAD_LEFT);
    
        while($currentDay <= $numberOfDays){
            // si dernier jour de la semaine, commencer une nouvelle ligne
            if($dayOfWeek == 7){
                $dayOfWeek = 0;
                $calendar .= "</tr><tr>";
            }
    
            $currentDayRel = str_pad($currentDay, 2, '0', STR_PAD_LEFT);
            $date = "$year-$month-$currentDayRel";
            $totalBookings = count($reservationRepository->findByDate($date));
    
            // attribuer la classe 'today' au jour actuel pour lui mettre un background en css
            $dateToday = date('Y-m-d');
            $classToday = $dateToday == $date ? 'today' : '';
    
            $dayName = strtolower(date("l",strtotime($date)));
    
            /* réservation possible tous les jours à partir d'aujourd'hui, sauf les dimanches
            $totalBookings = nombre de réservation total possible par jour*/

            if($dayName !='sunday' && $date>=date('Y-m-d') && $totalBookings<9){
                $calendar .= "<td class='$classToday dateTd'><button class='ajax date' data-date=$date>
                <h4 class='date'>$currentDay</h4></button></td>";
            }
            else{
                $calendar .= "<td class='$classToday'><h4>$currentDay</h4></td>";
            }
            
            
    
            // on incrémente les compteurs
            $currentDay++;
            $dayOfWeek++;
        }
    
        // cases vides à la fin du mois si celui-ci ne finit pas par dimanche
        if($dayOfWeek != 7){
            $remainingDays = 7-$dayOfWeek;
            for ($i=0; $i < $remainingDays ; $i++) { 
                $calendar.= "<td></td>";
            }
        }
    $calendar.= "</tr></body></table>";
    return $calendar;
    }
    
    

}