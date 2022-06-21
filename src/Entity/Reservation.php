<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime_immutable')]
    private $date;

    #[ORM\Column(type: 'string', length: 50)]
    private $lastname;

    #[ORM\Column(type: 'string', length: 50)]
    private $firstname;

    #[ORM\Column(type: 'string', length: 255)]
    private $email;

    #[ORM\Column(type: 'string', length: 30)]
    private $telephone;

    #[ORM\ManyToOne(targetEntity: Massagist::class, inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private $massagist;

    #[ORM\ManyToOne(inversedBy: 'reservation', targetEntity: Massage::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $massage;

    #[ORM\OneToOne(mappedBy: 'reservation', targetEntity: Payement::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true)]
    private $payement;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getMassagist(): ?Massagist
    {
        return $this->massagist;
    }

    public function setMassagist(?Massagist $massagist): self
    {
        $this->massagist = $massagist;

        return $this;
    }

    public function getMassage(): ?Massage
    {
        return $this->massage;
    }

    public function setMassage(Massage $massage): self
    {
        $this->massage = $massage;

        return $this;
    }

    public function getPayement(): ?Payement
    {
        return $this->payement;
    }

    public function setPayement(?Payement $payement): self
    {
        // unset the owning side of the relation if necessary
        if ($payement === null && $this->payement !== null) {
            $this->payement->setReservation(null);
        }

        // set the owning side of the relation if necessary
        if ($payement !== null && $payement->getReservation() !== $this) {
            $payement->setReservation($this);
        }

        $this->payement = $payement;

        return $this;
    }

}
