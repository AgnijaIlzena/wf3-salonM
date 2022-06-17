<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Massagist;
use Faker;


class MassagistFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {   

        $faker = Faker\Factory::create();
        
        for ($i=0; $i < 5; $i++) { 

            $massagist = new Massagist();
            $massagist->setName($faker->name);
            $massagist->setDescription($faker->realText(200, 2));
            $massagist->setCover('masseur.jpg');
            $this->addReference("massagist_$i",$massagist);

            $manager->persist($massagist);
        }
        $manager->flush();
    }
}
