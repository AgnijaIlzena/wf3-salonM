<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Reservation;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;
use DateTimeImmutable;

class ReservationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create();
        $date = new DateTimeImmutable();
        $randDate = $date->modify('-'.rand(1,600).' days');


        for ($i=0; $i < 21; $i++) { 
            $reservation= new Reservation();
            $reservation->setDate($randDate);
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
