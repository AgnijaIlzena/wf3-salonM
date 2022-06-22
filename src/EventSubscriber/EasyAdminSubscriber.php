<?php

namespace App\EventSubscriber;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{
	private UserPasswordHasherInterface $security;

	public function  __construct(UserPasswordHasherInterface $passwordHasher)
	{
		$this->security = $passwordHasher;
	}

	public static function getSubscribedEvents()
	{
		return [
			BeforeEntityPersistedEvent::class => ['createHashPassword'],
			BeforeEntityUpdatedEvent::class => ['updateHashPassword'],
		];
	}

	public function createHashPassword(BeforeEntityPersistedEvent $event)
	{
		$entity = $event->getEntityInstance();

		if (!$entity instanceof User) {
			return;
		}

		$this->setHashPassword($entity);
	}

	public function updateHashPassword(BeforeEntityUpdatedEvent $event)
	{
		$entity = $event->getEntityInstance();

		if (!$entity instanceof User) {
			return;
		}

		$this->setHashPassword($entity);
	}

	public function setHashPassword(User $user)
	{
		$user->setPassword(
			$this->security->hashPassword($user, $user->getPassword())
		);
	}
}
