<?php

namespace App\Entity;

use App\Repository\FamilleSousCRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FamilleSousCRepository::class)
 */
class FamilleSousC
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
    private $IDFamilleSousC;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $FamilleSousC;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $SArabeC;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Photo;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Ordre;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Visib;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $DateSys;

    /**
     * @ORM\ManyToOne(targetEntity=FamilleCarte::class, inversedBy="familleSousCs")
     */
    private $FamilleC;

    /**
     * @ORM\OneToMany(targetEntity=Produit::class, mappedBy="FamilleSousC")
     */
    private $produits;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIDFamilleSousC(): ?string
    {
        return $this->IDFamilleSousC;
    }

    public function setIDFamilleSousC(string $IDFamilleSousC): self
    {
        $this->IDFamilleSousC = $IDFamilleSousC;

        return $this;
    }

    public function getFamilleSousC(): ?string
    {
        return $this->FamilleSousC;
    }

    public function setFamilleSousC(string $FamilleSousC): self
    {
        $this->FamilleSousC = $FamilleSousC;

        return $this;
    }

    public function getSArabeC(): ?string
    {
        return $this->SArabeC;
    }

    public function setSArabeC(?string $SArabeC): self
    {
        $this->SArabeC = $SArabeC;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->Photo;
    }

    public function setPhoto(?string $Photo): self
    {
        $this->Photo = $Photo;

        return $this;
    }

    public function getOrdre(): ?int
    {
        return $this->Ordre;
    }

    public function setOrdre(?int $Ordre): self
    {
        $this->Ordre = $Ordre;

        return $this;
    }

    public function getVisib(): ?int
    {
        return $this->Visib;
    }

    public function setVisib(?int $Visib): self
    {
        $this->Visib = $Visib;

        return $this;
    }

    public function getDateSys(): ?\DateTimeInterface
    {
        return $this->DateSys;
    }

    public function setDateSys(?\DateTimeInterface $DateSys): self
    {
        $this->DateSys = $DateSys;

        return $this;
    }

    public function getFamilleC(): ?FamilleCarte
    {
        return $this->FamilleC;
    }

    public function setFamilleC(?FamilleCarte $FamilleC): self
    {
        $this->FamilleC = $FamilleC;

        return $this;
    }

    /**
     * @return Collection|Produit[]
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits[] = $produit;
            $produit->setFamilleSousC($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getFamilleSousC() === $this) {
                $produit->setFamilleSousC(null);
            }
        }

        return $this;
    }
}
