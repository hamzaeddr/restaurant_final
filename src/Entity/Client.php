<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
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
    private $IdClient;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Client;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $TypeClient;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Morale;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Contact;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Portable;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Obs;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $Active;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $DateSys;

    /**
     * @ORM\ManyToOne(targetEntity=TypeTarif::class, inversedBy="clients")
     */
    private $Tarif;

    /**
     * @ORM\OneToMany(targetEntity=ClientBeneficiaire::class, mappedBy="Client")
     */
    private $clientBeneficiaires;

    /**
     * @ORM\OneToMany(targetEntity=Carte::class, mappedBy="Client")
     */
    private $cartes;

    /**
     * @ORM\OneToMany(targetEntity=Facturation::class, mappedBy="Client")
     */
    private $facturations;

    public function __construct()
    {
        $this->clientBeneficiaires = new ArrayCollection();
        $this->cartes = new ArrayCollection();
        $this->facturations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdClient(): ?string
    {
        return $this->IdClient;
    }

    public function setIdClient(string $IdClient): self
    {
        $this->IdClient = $IdClient;

        return $this;
    }

    public function getClient(): ?string
    {
        return $this->Client;
    }

    public function setClient(string $Client): self
    {
        $this->Client = $Client;

        return $this;
    }

    public function getTypeClient(): ?string
    {
        return $this->TypeClient;
    }

    public function setTypeClient(?string $TypeClient): self
    {
        $this->TypeClient = $TypeClient;

        return $this;
    }

    public function getMorale(): ?int
    {
        return $this->Morale;
    }

    public function setMorale(?int $Morale): self
    {
        $this->Morale = $Morale;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->Contact;
    }

    public function setContact(?string $Contact): self
    {
        $this->Contact = $Contact;

        return $this;
    }

    public function getPortable(): ?string
    {
        return $this->Portable;
    }

    public function setPortable(?string $Portable): self
    {
        $this->Portable = $Portable;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(?string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    public function getObs(): ?string
    {
        return $this->Obs;
    }

    public function setObs(?string $Obs): self
    {
        $this->Obs = $Obs;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->Active;
    }

    public function setActive(?bool $Active): self
    {
        $this->Active = $Active;

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
            $clientBeneficiaire->setClient($this);
        }

        return $this;
    }

    public function removeClientBeneficiaire(ClientBeneficiaire $clientBeneficiaire): self
    {
        if ($this->clientBeneficiaires->removeElement($clientBeneficiaire)) {
            // set the owning side to null (unless already changed)
            if ($clientBeneficiaire->getClient() === $this) {
                $clientBeneficiaire->setClient(null);
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
            $carte->setClient($this);
        }

        return $this;
    }

    public function removeCarte(Carte $carte): self
    {
        if ($this->cartes->removeElement($carte)) {
            // set the owning side to null (unless already changed)
            if ($carte->getClient() === $this) {
                $carte->setClient(null);
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
            $facturation->setClient($this);
        }

        return $this;
    }

    public function removeFacturation(Facturation $facturation): self
    {
        if ($this->facturations->removeElement($facturation)) {
            // set the owning side to null (unless already changed)
            if ($facturation->getClient() === $this) {
                $facturation->setClient(null);
            }
        }

        return $this;
    }
}
