<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?User $User_Reservation = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?Urgence $Urgence = null;

    #[ORM\Column(length: 255)]
    private ?string $Description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $Date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserReservation(): ?User
    {
        return $this->User_Reservation;
    }

    public function setUserReservation(?User $User_Reservation): static
    {
        $this->User_Reservation = $User_Reservation;

        return $this;
    }

    public function getUrgence(): ?Urgence
    {
        return $this->Urgence;
    }

    public function setUrgence(?Urgence $Urgence): static
    {
        $this->Urgence = $Urgence;

        return $this;
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): static
    {
        $this->Date = $Date;

        return $this ;
    }
}
