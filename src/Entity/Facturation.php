<?php

namespace App\Entity;

use App\Repository\FacturationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FacturationRepository::class)
 */
class Facturation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $NumFact;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $DateFact;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $DemandeA;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $DateA;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="facturations")
     */
    private $Client;

    /**
     * @ORM\ManyToOne(targetEntity=ClientBeneficiaire::class, inversedBy="facturations")
     */
    private $Beneiciaire;

    /**
     * @ORM\ManyToOne(targetEntity=TypeTarif::class, inversedBy="facturations")
     */
    private $Tarif;

    /**
     * @ORM\OneToMany(targetEntity=Carte::class, mappedBy="Facture")
     */
    private $cartes;

    public function __construct()
    {
        $this->cartes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumFact(): ?string
    {
        return $this->NumFact;
    }

    public function setNumFact(string $NumFact): self
    {
        $this->NumFact = $NumFact;

        return $this;
    }

    public function getDateFact(): ?\DateTimeInterface
    {
        return $this->DateFact;
    }

    public function setDateFact(?\DateTimeInterface $DateFact): self
    {
        $this->DateFact = $DateFact;

        return $this;
    }

    public function getDemandeA(): ?string
    {
        return $this->DemandeA;
    }

    public function setDemandeA(?string $DemandeA): self
    {
        $this->DemandeA = $DemandeA;

        return $this;
    }

    public function getDateA(): ?\DateTimeInterface
    {
        return $this->DateA;
    }

    public function setDateA(?\DateTimeInterface $DateA): self
    {
        $this->DateA = $DateA;

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

    public function getBeneiciaire(): ?ClientBeneficiaire
    {
        return $this->Beneiciaire;
    }

    public function setBeneiciaire(?ClientBeneficiaire $Beneiciaire): self
    {
        $this->Beneiciaire = $Beneiciaire;

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
            $carte->setFacture($this);
        }

        return $this;
    }

    public function removeCarte(Carte $carte): self
    {
        if ($this->cartes->removeElement($carte)) {
            // set the owning side to null (unless already changed)
            if ($carte->getFacture() === $this) {
                $carte->setFacture(null);
            }
        }

        return $this;
    }
}
