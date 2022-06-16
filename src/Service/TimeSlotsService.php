<?php
namespace App\Service;
use DateTime;
use DateInterval;

class TimeSlotsService{
    function timeslots($duration, $cleanUp, $start, $end)
    {
        $start = new DateTime($start);
        $end = new DateTime($end);
        // intervalle : création d'un objet DateInterval à partir d'un int en minutes
        // PT60M créé un intervalle de 60 minutes
        // $interval = durée du slot (temps en min entre 2 dateTimes)
        $interval = new DateInterval("PT".$duration."M");
    
        // $cleanUp = intervalle entre 2 slots
        $cleanUpInterval = new DateInterval("PT".$cleanUp."M");
        $slots = [];
    
        // add = méthode de l'objet DateTime pour rajouter un intervalle
        // boucle qui créée des objets DateTime entre le DateTime de début 
        // et le DateTime de fin, en tenant compte de l'intervalle et du cleanUp
        for ($intStart = $start; $intStart < $end; $intStart->add($interval)->add($cleanUpInterval)) {
            $endPeriod = clone $intStart;
            $endPeriod->add($interval);
            if ($endPeriod > $end) {
                break;
            }
            $slots[] = $intStart->format("H:iA")."-".$endPeriod->format("H:iA");
        }
        return $slots;
    }
    
}