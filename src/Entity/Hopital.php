<?php

namespace App\Entity;

use App\Repository\HopitalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HopitalRepository::class)]
class Hopital
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    #[ORM\Column(length: 255)]
    private ?string $Localisation = null;

    #[ORM\OneToMany(targetEntity: HopitalImage::class, mappedBy: 'Hopital')]
    private Collection $hopitalImages;

    #[ORM\Column(length: 255)]
    private ?string $Email = null;

    #[ORM\Column]
    private ?int $Num = null;

    public function __construct()
    {
        $this->hopitalImages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): static
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->Localisation;
    }

    public function setLocalisation(string $Localisation): static
    {
        $this->Localisation = $Localisation;

        return $this;
    }

    /**
     * @return Collection<int, HopitalImage>
     */
    public function getHopitalImages(): Collection
    {
        return $this->hopitalImages;
    }

    public function addHopitalImage(HopitalImage $hopitalImage): static
    {
        if (!$this->hopitalImages->contains($hopitalImage)) {
            $this->hopitalImages->add($hopitalImage);
            $hopitalImage->setHopital($this);
        }

        return $this;
    }

    public function removeHopitalImage(HopitalImage $hopitalImage): static
    {
        if ($this->hopitalImages->removeElement($hopitalImage)) {
            // set the owning side to null (unless already changed)
            if ($hopitalImage->getHopital() === $this) {
                $hopitalImage->setHopital(null);
            }
        }

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): static
    {
        $this->Email = $Email;

        return $this;
    }

    public function getNum(): ?int
    {
        return $this->Num;
    }

    public function setNum(int $Num): static
    {
        $this->Num = $Num;

        return $this;
    }
}
