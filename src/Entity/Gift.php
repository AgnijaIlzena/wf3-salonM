<?php

namespace App\Entity;

use App\Repository\GiftRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GiftRepository::class)]
class Gift
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $sender;

    #[ORM\Column(type: 'string', length: 50)]
    private $receiver;

    #[ORM\Column(type: 'string', length: 200)]
    private $sender_email;

    #[ORM\Column(type: 'string', length: 200)]
    private $receiver_email;

    #[ORM\Column(type: 'string', length: 200)]
    private $message;

    #[ORM\ManyToOne(targetEntity: Massage::class, inversedBy: 'gifts')]
    #[ORM\JoinColumn(nullable: false)]
    private $massage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSender(): ?string
    {
        return $this->sender;
    }

    public function setSender(string $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    public function getReceiver(): ?string
    {
        return $this->receiver;
    }

    public function setReceiver(string $receiver): self
    {
        $this->receiver = $receiver;

        return $this;
    }

    public function getSenderEmail(): ?string
    {
        return $this->sender_email;
    }

    public function setSenderEmail(string $sender_email): self
    {
        $this->sender_email = $sender_email;

        return $this;
    }

    public function getReceiverEmail(): ?string
    {
        return $this->receiver_email;
    }

    public function setReceiverEmail(string $receiver_email): self
    {
        $this->receiver_email = $receiver_email;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getMassage(): ?massage
    {
        return $this->massage;
    }

    public function setMassage(?massage $massage): self
    {
        $this->massage = $massage;

        return $this;
    }
    
}
