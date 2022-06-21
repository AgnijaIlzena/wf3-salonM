<?php

namespace App\Controller\EventSubscriber;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class EasyAdminSubscriber implements EventSubscriberInterface {

    private $security;
    
    public function  __construct(UserPasswordHasherInterface $passwordHasher) {
        $this->security = $passwordHasher;
    }
 
    public static function getSubscribedEvents(){
        return [
            BeforeEntityPersistedEvent::class => ["setHashPassword"],
        ];
    }

    public function setHashPassword(BeforeEntityPersistedEvent $event){
        $entity = $event->getEntityInstance();
        if(!$entity instanceof User){
            return ;
        }

        $entity->setPassword($this->security->hashPassword($entity, $entity->getPassword()));
    
    }
}