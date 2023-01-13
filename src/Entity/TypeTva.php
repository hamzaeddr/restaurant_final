<?php

namespace App\Entity;

use App\Repository\TypeTvaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypeTvaRepository::class)
 */
class TypeTva
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $LibelleTva;

    /**
     * @ORM\Column(type="float")
     */
    private $Taux;

    /**
     * @ORM\OneToMany(targetEntity=TypeTarif::class, mappedBy="TVA")
     */
    private $typeTarifs;

    public function __construct()
    {
        $this->typeTarifs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleTva(): ?string
    {
        return $this->LibelleTva;
    }

    public function setLibelleTva(string $LibelleTva): self
    {
        $this->LibelleTva = $LibelleTva;

        return $this;
    }

    public function getTaux(): ?float
    {
        return $this->Taux;
    }

    public function setTaux(float $Taux): self
    {
        $this->Taux = $Taux;

        return $this;
    }

    /**
     * @return Collection|TypeTarif[]
     */
    public function getTypeTarifs(): Collection
    {
        return $this->typeTarifs;
    }

    public function addTypeTarif(TypeTarif $typeTarif): self
    {
        if (!$this->typeTarifs->contains($typeTarif)) {
            $this->typeTarifs[] = $typeTarif;
            $typeTarif->setTVA($this);
        }

        return $this;
    }

    public function removeTypeTarif(TypeTarif $typeTarif): self
    {
        if ($this->typeTarifs->removeElement($typeTarif)) {
            // set the owning side to null (unless already changed)
            if ($typeTarif->getTVA() === $this) {
                $typeTarif->setTVA(null);
            }
        }

        return $this;
    }
}
