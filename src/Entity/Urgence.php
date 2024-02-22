<?php

namespace App\Entity;

use App\Repository\UrgenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UrgenceRepository::class)]
class Urgence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Description = null;

    #[ORM\Column]
    private ?int $NombreLit = null;

    #[ORM\Column(length: 255)]
    private ?string $Specialite = null;

    #[ORM\Column]
    private ?int $NombreLitDisponible = null;

    #[ORM\OneToOne(cascade: ['persist'])]
    private ?Hopital $Hopital = null;

    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'Urgence')]
    private Collection $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    public function getNombreLit(): ?int
    {
        return $this->NombreLit;
    }

    public function setNombreLit(int $NombreLit): static
    {
        $this->NombreLit = $NombreLit;

        return $this;
    }

    public function getSpecialite(): ?string
    {
        return $this->Specialite;
    }

    public function setSpecialite(string $Specialite): static
    {
        $this->Specialite = $Specialite;

        return $this;
    }

    public function getNombreLitDisponible(): ?int
    {
        return $this->NombreLitDisponible;
    }

    public function setNombreLitDisponible(int $NombreLitDisponible): static
    {
        $this->NombreLitDisponible = $NombreLitDisponible;

        return $this;
    }

    public function getHopital(): ?Hopital
    {
        return $this->Hopital;
    }

    public function setHopital(?Hopital $Hopital): static
    {
        $this->Hopital = $Hopital;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setUrgence($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getUrgence() === $this) {
                $reservation->setUrgence(null);
            }
        }

        return $this;
    }
}
