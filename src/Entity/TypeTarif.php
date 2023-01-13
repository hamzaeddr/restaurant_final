<?php

namespace App\Entity;

use App\Repository\TypeTarifRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypeTarifRepository::class)
 */
class TypeTarif
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
    private $Tarif;

    /**
     * @ORM\ManyToOne(targetEntity=TypeTva::class, inversedBy="typeTarifs")
     */
    private $TVA;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ParDefaut;

    /**
     * @ORM\OneToMany(targetEntity=Client::class, mappedBy="Tarif")
     */
    private $clients;

    /**
     * @ORM\OneToMany(targetEntity=ClientBeneficiaire::class, mappedBy="Tarif")
     */
    private $clientBeneficiaires;

    /**
     * @ORM\OneToMany(targetEntity=ProduitTarif::class, mappedBy="Tarif")
     */
    private $produitTarifs;

    /**
     * @ORM\OneToMany(targetEntity=Carte::class, mappedBy="Tarif")
     */
    private $cartes;

    /**
     * @ORM\OneToMany(targetEntity=Facturation::class, mappedBy="Tarif")
     */
    private $facturations;

    public function __construct()
    {
        $this->clients = new ArrayCollection();
        $this->clientBeneficiaires = new ArrayCollection();
        $this->produitTarifs = new ArrayCollection();
        $this->cartes = new ArrayCollection();
        $this->facturations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTarif(): ?string
    {
        return $this->Tarif;
    }

    public function setTarif(string $Tarif): self
    {
        $this->Tarif = $Tarif;

        return $this;
    }

    public function getTVA(): ?TypeTva
    {
        return $this->TVA;
    }

    public function setTVA(?TypeTva $TVA): self
    {
        $this->TVA = $TVA;

        return $this;
    }

    public function getParDefaut(): ?int
    {
        return $this->ParDefaut;
    }

    public function setParDefaut(?int $ParDefaut): self
    {
        $this->ParDefaut = $ParDefaut;

        return $this;
    }

    /**
     * @return Collection|Client[]
     */
    public function getClients(): Collection
    {
        return $this->clients;
    }

    public function addClient(Client $client): self
    {
        if (!$this->clients->contains($client)) {
            $this->clients[] = $client;
            $client->setTarif($this);
        }

        return $this;
    }

    public function removeClient(Client $client): self
    {
        if ($this->clients->removeElement($client)) {
            // set the owning side to null (unless already changed)
            if ($client->getTarif() === $this) {
                $client->setTarif(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ClientBeneficiaire[]
     */
    public function getClientBeneficiaires(): Collection
    {
        return $this->clientBeneficiaires;
    }

    public function addClientBeneficiaire(ClientBeneficiaire $clientBeneficiaire): self
    {
        if (!$this->clientBeneficiaires->contains($clientBeneficiaire)) {
            $this->clientBeneficiaires[] = $clientBeneficiaire;
            $clientBeneficiaire->setTarif($this);
        }

        return $this;
    }

    public function removeClientBeneficiaire(ClientBeneficiaire $clientBeneficiaire): self
    {
        if ($this->clientBeneficiaires->removeElement($clientBeneficiaire)) {
            // set the owning side to null (unless already changed)
            if ($clientBeneficiaire->getTarif() === $this) {
                $clientBeneficiaire->setTarif(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProduitTarif[]
     */
    public function getProduitTarifs(): Collection
    {
        return $this->produitTarifs;
    }

    public function addProduitTarif(ProduitTarif $produitTarif): self
    {
        if (!$this->produitTarifs->contains($produitTarif)) {
            $this->produitTarifs[] = $produitTarif;
            $produitTarif->setTarif($this);
        }

        return $this;
    }

    public function removeProduitTarif(ProduitTarif $produitTarif): self
    {
        if ($this->produitTarifs->removeElement($produitTarif)) {
            // set the owning side to null (unless already changed)
            if ($produitTarif->getTarif() === $this) {
                $produitTarif->setTarif(null);
            }
        }

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
            $carte->setTarif($this);
        }

        return $this;
    }

    public function removeCarte(Carte $carte): self
    {
        if ($this->cartes->removeElement($carte)) {
            // set the owning side to null (unless already changed)
            if ($carte->getTarif() === $this) {
                $carte->setTarif(null);
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
            $facturation->setTarif($this);
        }

        return $this;
    }

    public function removeFacturation(Facturation $facturation): self
    {
        if ($this->facturations->removeElement($facturation)) {
            // set the owning side to null (unless already changed)
            if ($facturation->getTarif() === $this) {
                $facturation->setTarif(null);
            }
        }

        return $this;
    }
}
