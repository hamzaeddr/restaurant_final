<?php

namespace App\Entity;

use App\Repository\TypeFamilleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypeFamilleRepository::class)
 */
class TypeFamille
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
    private $TypeFamille;

    /**
     * @ORM\OneToMany(targetEntity=FamilleCarte::class, mappedBy="TypeFamille")
     */
    private $familleCartes;

    public function __construct()
    {
        $this->familleCartes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeFamille(): ?string
    {
        return $this->TypeFamille;
    }

    public function setTypeFamille(string $TypeFamille): self
    {
        $this->TypeFamille = $TypeFamille;

        return $this;
    }

    /**
     * @return Collection|FamilleCarte[]
     */
    public function getFamilleCartes(): Collection
    {
        return $this->familleCartes;
    }

    public function addFamilleCarte(FamilleCarte $familleCarte): self
    {
        if (!$this->familleCartes->contains($familleCarte)) {
            $this->familleCartes[] = $familleCarte;
            $familleCarte->setTypeFamille($this);
        }

        return $this;
    }

    public function removeFamilleCarte(FamilleCarte $familleCarte): self
    {
        if ($this->familleCartes->removeElement($familleCarte)) {
            // set the owning side to null (unless already changed)
            if ($familleCarte->getTypeFamille() === $this) {
                $familleCarte->setTypeFamille(null);
            }
        }

        return $this;
    }
}
