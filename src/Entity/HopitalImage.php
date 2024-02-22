<?php

namespace App\Entity;

use App\Repository\HopitalImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HopitalImageRepository::class)]
class HopitalImage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $ImageUrl = null;

    #[ORM\ManyToOne(inversedBy: 'hopitalImages')]
    private ?Hopital $Hopital = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImageUrl(): ?string
    {
        return $this->ImageUrl;
    }

    public function setImageUrl(string $ImageUrl): static
    {
        $this->ImageUrl = $ImageUrl;

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
}
