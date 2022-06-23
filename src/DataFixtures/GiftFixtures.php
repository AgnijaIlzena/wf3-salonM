<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Gift;
use App\Entity\Massage;
use DateTimeImmutable;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
class GiftFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for($i = 0; $i < 6; $i++) {

            $number = rand(1, 500);
            $date = new DateTimeImmutable();
            $randDate = $date->modify("+$number day");
           
            $gift = new Gift();
            $gift->setSender("sender_$i");
            $gift->setReceiver("receiver_$i");
            $gift->setSenderEmail("sender_email_$i");
            $gift->setReceiverEmail("recevier_email_$i");
            $gift->setDate($randDate);
            $gift->setMessage("message_$i");

            $gift->setMassage($this->getReference("massage_".rand(0, 6)));
            $manager->persist($gift);
        }
 
        // Insère en BDD
        $manager->flush();
    }
    public function getDependencies(){
        return[
            MassagistFixtures::class,
            MassageFixtures::class
        ];
    }
        
    }

