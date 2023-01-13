<?php

namespace App\Entity;

use App\Repository\ClientBeneficiaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClientBeneficiaireRepository::class)
 */
class ClientBeneficiaire
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
    private $IdBeneficiaire;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Beneficiaire;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Abrev;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Responsable;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $DateSys;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="clientBeneficiaires")
     */
    private $Client;

    /**
     * @ORM\ManyToOne(targetEntity=TypeTarif::class, inversedBy="clientBeneficiaires")
     */
    private $Tarif;

    /**
     * @ORM\OneToMany(targetEntity=Carte::class, mappedBy="Beneficiaire")
     */
    private $cartes;

    /**
     * @ORM\OneToMany(targetEntity=Facturation::class, mappedBy="Beneiciaire")
     */
    private $facturations;

    public function __construct()
    {
        $this->cartes = new ArrayCollection();
        $this->facturations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdBeneficiaire(): ?string
    {
        return $this->IdBeneficiaire;
    }

    public function setIdBeneficiaire(string $IdBeneficiaire): self
    {
        $this->IdBeneficiaire = $IdBeneficiaire;

        return $this;
    }

    public function getBeneficiaire(): ?string
    {
        return $this->Beneficiaire;
    }

    public function setBeneficiaire(string $Beneficiaire): self
    {
        $this->Beneficiaire = $Beneficiaire;

        return $this;
    }

    public function getAbrev(): ?string
    {
        return $this->Abrev;
    }

    public function setAbrev(?string $Abrev): self
    {
        $this->Abrev = $Abrev;

        return $this;
    }

    public function getResponsable(): ?string
    {
        return $this->Responsable;
    }

    public function setResponsable(?string $Responsable): self
    {
        $this->Responsable = $Responsable;

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

    public function getClient(): ?Client
    {
        return $this->Client;
    }

    public function setClient(?Client $Client): self
    {
        $this->Client = $Client;

        return $this;
    }

    public function getTarif(): ?TypeTarif
    {
        return $this->Tarif;
    }

    public function setTarif(?TypeTarif $Tarif): self
    {
        $this->Tarif = $Tarif;

        return $this;
    }

    /**
     * @return Collection|Carte[]
     */
    public function getCartes(): Collection
    {
        return $this->cartes;
    }

    public function addCarte(Carte $carte): self
    {
        if (!$this->cartes->contains($carte)) {
            $this->cartes[] = $carte;
            $carte->setBeneficiaire($this);
        }

        return $this;
    }

    public function removeCarte(Carte $carte): self
    {
        if ($this->cartes->removeElement($carte)) {
            // set the owning side to null (unless already changed)
            if ($carte->getBeneficiaire() === $this) {
                $carte->setBeneficiaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Facturation[]
     */
    public function getFacturations(): Collection
    {
        return $this->facturations;
    }

    public function addFacturation(Facturation $facturation): self
    {
        if (!$this->facturations->contains($facturation)) {
            $this->facturations[] = $facturation;
            $facturation->setBeneiciaire($this);
        }

        return $this;
    }

    public function removeFacturation(Facturation $facturation): self
    {
        if ($this->facturations->removeElement($facturation)) {
            // set the owning side to null (unless already changed)
            if ($facturation->getBeneiciaire() === $this) {
                $facturation->setBeneiciaire(null);
            }
        }

        return $this;
    }
}
