<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Reservation;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class ReservationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create();
        // $date = new DateTimeImmutable('now');
        // $randDate = $date->modify('+'.rand(1,600).' days');

        // tableau de timeslots, si heure de début < à 10, rajouter un 0
        for ($i=9; $i < 18; $i++) { 
            $timeslot[] = $i>=10? $i.':00PM-'.($i+1).':00PM': '0'.$i.':00PM-'.($i+1).':00PM';
        }

        for ($i=0; $i < 21; $i++) { 
            $reservation= new Reservation();
            
            $reservation->setDate($faker->dateTimeBetween('now','+6months')->format('Y-m-d'));
            $reservation->setTimeslot($timeslot[rand(0,count($timeslot)-1)]);
            $reservation->setLastname($faker->lastName);
            $reservation->setFirstname($faker->firstName);
            $reservation->setEmail($faker->email);
            $reservation->setTelephone($faker->phoneNumber);
            $reservation->setMassagist($this->getReference("massagist_".rand(0,4)));
            $reservation->setMassage($this->getReference("massage_".rand(0,6)));

            $manager->persist($reservation);
        }
        $manager->flush();
    }
    public function getDependencies(){
        return[
            MassagistFixtures::class,
            MassageFixtures::class
        ];
    }
}
