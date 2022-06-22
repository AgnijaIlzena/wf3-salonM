<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;


class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setFirstName('Admin');
        $user->setLastName('Admin');
        $user->setEmail('admin@admin.com');
        $user->setPassword('password');
        $user->setRoles(array('ROLE_ADMIN'));
        $user->setIsVerified(true);

        $manager->persist($user);
    
        $manager->flush();
    }
}
