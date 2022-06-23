<?php

namespace App\Entity;

use App\Repository\MassageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File as FileFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Stringable;


use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: MassageRepository::class)]
#[Vich\Uploadable] 
class Massage implements Stringable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $name;


    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\OneToMany(mappedBy: 'massage', targetEntity: Reservation::class, cascade: ['persist', 'remove'])]
    #[Ignore]
    private $reservation;

    #[ORM\OneToMany(mappedBy: 'massage', targetEntity: Gift::class, orphanRemoval: true)]
    private $gifts;

    public function __construct()
    {
        $this->gifts = new ArrayCollection();
    }
    #[ORM\Column(type: 'integer')]
    private $price;


    // #[ORM\Column(type: 'string', length: 255, nullable: true)]
    // private $cover = '';

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $cover;

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(string $cover): self
    {
        $this->cover = $cover;

        return $this;
    }
    

    #[Vich\UploadableField(mapping: 'products', fileNameProperty: 'cover')]
    private ?FileFile $file = null;
    
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

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getReservation(): ?Reservation
    {
        return $this->reservation;
    }

    public function setReservation(Reservation $reservation): self
    {
        // set the owning side of the relation if necessary
        if ($reservation->getMassage() !== $this) {
            $reservation->setMassage($this);
        }

        $this->reservation = $reservation;

        return $this;
    }

    /**
     * @return Collection<int, Gift>
     */
    public function getGifts(): Collection
    {
        return $this->gifts;
    }

    public function addGift(Gift $gift): self
    {
        if (!$this->gifts->contains($gift)) {
            $this->gifts[] = $gift;
            $gift->setMassage($this);
        }

        return $this;
    }

    public function removeGift(Gift $gift): self
    {
        if ($this->gifts->removeElement($gift)) {
            // set the owning side to null (unless already changed)
            if ($gift->getMassage() === $this) {
                $gift->setMassage(null);
            }
        }

        return $this;
    }

    /**
     * Get the value of file
     */ 
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set the value of file
     *
     * @return  self
     */ 
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;       
    }
}
