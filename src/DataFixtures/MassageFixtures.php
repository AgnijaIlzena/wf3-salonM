<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use App\Entity\Massage;

class MassageFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create();
        
        for ($i=0; $i < 7; $i++) { 

            $massage = new Massage();
            $massage->setName($faker->colorName);
            $massage->setPrice($faker->numberBetween(50,100));
            $massage->setDescription($faker->realText(200, 2));
            $massage->setCover('massage.jpg');
            $this->addReference("massage_$i",$massage);

            $manager->persist($massage);
        }
        $manager->flush();
    }
}
