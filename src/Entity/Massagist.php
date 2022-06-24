<?php

namespace App\Entity;

use App\Repository\MassagistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Stringable;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use DateTimeImmutable;


#[ORM\Entity(repositoryClass: MassagistRepository::class)]
#[Vich\Uploadable]
class Massagist implements Stringable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $name;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\OneToMany(mappedBy: 'massagist', targetEntity: Reservation::class, orphanRemoval: true)]
    #[Ignore]
    private $reservations;

    #[ORM\Column(type: 'string', length: 50)]
    private $cover;

    #[Vich\UploadableField(mapping: 'products', fileNameProperty: 'cover')]
    #[Assert\Image(mimeTypesMessage: 'Ce fichier n\'est pas une image')]
    #[Assert\File(maxSize: '1M', maxSizeMessage: 'Le fichier ne doit pas dépasser les {{ limit }} {{ suffix }}')]
    private  $profileFile;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private $updated_at;


    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setMassagist($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getMassagist() === $this) {
                $reservation->setMassagist(null);
            }
        }

        return $this;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(?string $cover): self
    {
        $this->cover = $cover;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }


    /**
     * Get the value of profilefile
     */ 
    public function getProfileFile(): ?File
    {
        return $this->profileFile;
    }

    public function setProfileFile(?File $profileFile = null): self
    {
        $this->profileFile = $profileFile;

        if ($profileFile !== null) {
            $this->updated_at = new DateTimeImmutable();
        }

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
    
}
