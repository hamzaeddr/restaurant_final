<?php

namespace App\Entity;

use App\Repository\FamilleCarteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FamilleCarteRepository::class)
 */
class FamilleCarte
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
    private $IdFamilleC;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $FamilleC;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $FArabeC;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Photo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $PhotoBorn;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $PhotoXL;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $CouleurBtn;

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
     * @ORM\ManyToOne(targetEntity=TypeFamille::class, inversedBy="familleCartes")
     */
    private $TypeFamille;

    /**
     * @ORM\OneToMany(targetEntity=FamilleSousC::class, mappedBy="FamilleC")
     */
    private $familleSousCs;

    public function __construct()
    {
        $this->familleSousCs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdFamilleC(): ?string
    {
        return $this->IdFamilleC;
    }

    public function setIdFamilleC(string $IdFamilleC): self
    {
        $this->IdFamilleC = $IdFamilleC;

        return $this;
    }

    public function getFamilleC(): ?string
    {
        return $this->FamilleC;
    }

    public function setFamilleC(string $FamilleC): self
    {
        $this->FamilleC = $FamilleC;

        return $this;
    }

    public function getFArabeC(): ?string
    {
        return $this->FArabeC;
    }

    public function setFArabeC(?string $FArabeC): self
    {
        $this->FArabeC = $FArabeC;

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

    public function getPhotoBorn(): ?string
    {
        return $this->PhotoBorn;
    }

    public function setPhotoBorn(?string $PhotoBorn): self
    {
        $this->PhotoBorn = $PhotoBorn;

        return $this;
    }

    public function getPhotoXL(): ?string
    {
        return $this->PhotoXL;
    }

    public function setPhotoXL(?string $PhotoXL): self
    {
        $this->PhotoXL = $PhotoXL;

        return $this;
    }

    public function getCouleurBtn(): ?int
    {
        return $this->CouleurBtn;
    }

    public function setCouleurBtn(?int $CouleurBtn): self
    {
        $this->CouleurBtn = $CouleurBtn;

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

    public function getTypeFamille(): ?TypeFamille
    {
        return $this->TypeFamille;
    }

    public function setTypeFamille(?TypeFamille $TypeFamille): self
    {
        $this->TypeFamille = $TypeFamille;

        return $this;
    }

    /**
     * @return Collection|FamilleSousC[]
     */
    public function getFamilleSousCs(): Collection
    {
        return $this->familleSousCs;
    }

    public function addFamilleSousC(FamilleSousC $familleSousC): self
    {
        if (!$this->familleSousCs->contains($familleSousC)) {
            $this->familleSousCs[] = $familleSousC;
            $familleSousC->setFamilleC($this);
        }

        return $this;
    }

    public function removeFamilleSousC(FamilleSousC $familleSousC): self
    {
        if ($this->familleSousCs->removeElement($familleSousC)) {
            // set the owning side to null (unless already changed)
            if ($familleSousC->getFamilleC() === $this) {
                $familleSousC->setFamilleC(null);
            }
        }

        return $this;
    }
}
