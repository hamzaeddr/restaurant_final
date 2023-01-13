<?php

namespace App\Entity;

use App\Entity\Carte;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CarteRepository;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @ORM\Entity(repositoryClass=CarteRepository::class)
 */
class Carte
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
    private $IdCarte;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $DateCreation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $TypeClient;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $NomCarte;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $DateValidite;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $Generer;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $Facturer;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $Annuler;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Obs;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $DateSys;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="cartes")
     */
    private $Client;

    /**
     * @ORM\ManyToOne(targetEntity=ClientBeneficiaire::class, inversedBy="cartes")
     */
    private $Beneficiaire;

    /**
     * @ORM\ManyToOne(targetEntity=TypeTarif::class, inversedBy="cartes")
     */
    private $Tarif;

    /**
     * @ORM\ManyToOne(targetEntity=TypeClient::class, inversedBy="cartes")
     */
    private $TypeClientId;

    /**
     * @ORM\OneToMany(targetEntity=CarteRepartition::class, mappedBy="Carte", orphanRemoval=true)
  
     */
    private $carteRepartitions;

    /**
     * @ORM\OneToMany(targetEntity=CarteLg::class, mappedBy="Carte" ,orphanRemoval=true)
     */
    private $carteLgs;

    /**
     * @ORM\ManyToOne(targetEntity=Facturation::class, inversedBy="cartes")
     */
    private $Facture;

    /**
     * @ORM\OneToMany(targetEntity=OperationO::class, mappedBy="Carte")
     */
    private $operationOs;

   

    public function __construct()
    {
        $this->carteRepartitions = new ArrayCollection();
        $this->carteLgs = new ArrayCollection();
        $this->operationOs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCarte(): ?string
    {
        return $this->IdCarte;
    }

    public function setIdCarte(string $IdCarte): self
    {
        $this->IdCarte = $IdCarte;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->DateCreation;
    }

    public function setDateCreation(?\DateTimeInterface $DateCreation): self
    {
        $this->DateCreation = $DateCreation;

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

    public function getNomCarte(): ?string
    {
        return $this->NomCarte;
    }

    public function setNomCarte(?string $NomCarte): self
    {
        $this->NomCarte = $NomCarte;

        return $this;
    }

    public function getDateValidite(): ?\DateTimeInterface
    {
        return $this->DateValidite;
    }

    public function setDateValidite(?\DateTimeInterface $DateValidite): self
    {
        $this->DateValidite = $DateValidite;

        return $this;
    }

    public function getGenerer(): ?bool
    {
        return $this->Generer;
    }

    public function setGenerer(?bool $Generer): self
    {
        $this->Generer = $Generer;

        return $this;
    }

    public function getFacturer(): ?bool
    {
        return $this->Facturer;
    }

    public function setFacturer(?bool $Facturer): self
    {
        $this->Facturer = $Facturer;

        return $this;
    }

    public function getAnnuler(): ?bool
    {
        return $this->Annuler;
    }

    public function setAnnuler(?bool $Annuler): self
    {
        $this->Annuler = $Annuler;

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

    public function getBeneficiaire(): ?ClientBeneficiaire
    {
        return $this->Beneficiaire;
    }

    public function setBeneficiaire(?ClientBeneficiaire $Beneficiaire): self
    {
        $this->Beneficiaire = $Beneficiaire;

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

    public function getTypeClientId(): ?TypeClient
    {
        return $this->TypeClientId;
    }

    public function setTypeClientId(?TypeClient $TypeClientId): self
    {
        $this->TypeClientId = $TypeClientId;

        return $this;
    }

    /**
     * @return Collection|CarteRepartition[]
     */
    public function getCarteRepartitions(): Collection
    {
        return $this->carteRepartitions;
    }

    public function addCarteRepartition(CarteRepartition $carteRepartition): self
    {
        if (!$this->carteRepartitions->contains($carteRepartition)) {
            $this->carteRepartitions[] = $carteRepartition;
            $carteRepartition->setCarte($this);
        }

        return $this;
    }

    public function removeCarteRepartition(CarteRepartition $carteRepartition): self
    {
        if ($this->carteRepartitions->removeElement($carteRepartition)) {
            // set the owning side to null (unless already changed)
            if ($carteRepartition->getCarte() === $this) {
                $carteRepartition->setCarte(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CarteLg[]
     */
    public function getCarteLgs(): Collection
    {
        return $this->carteLgs;
    }

    public function addCarteLg(CarteLg $carteLg): self
    {
        if (!$this->carteLgs->contains($carteLg)) {
            $this->carteLgs[] = $carteLg;
            $carteLg->setCarte($this);
        }

        return $this;
    }

    public function removeCarteLg(CarteLg $carteLg): self
    {
        if ($this->carteLgs->removeElement($carteLg)) {
            // set the owning side to null (unless already changed)
            if ($carteLg->getCarte() === $this) {
                $carteLg->setCarte(null);
            }
        }

        return $this;
    }

    public function getFacture(): ?facturation
    {
        return $this->Facture;
    }

    public function setFacture(?facturation $Facture): self
    {
        $this->Facture = $Facture;

        return $this;
    }

    /**
     * @return Collection<int, OperationO>
     */
    public function getOperationOs(): Collection
    {
        return $this->operationOs;
    }

    public function addOperationO(OperationO $operationO): self
    {
        if (!$this->operationOs->contains($operationO)) {
            $this->operationOs[] = $operationO;
            $operationO->setCarte($this);
        }

        return $this;
    }

    public function removeOperationO(OperationO $operationO): self
    {
        if ($this->operationOs->removeElement($operationO)) {
            // set the owning side to null (unless already changed)
            if ($operationO->getCarte() === $this) {
                $operationO->setCarte(null);
            }
        }

        return $this;
    }

   
}
