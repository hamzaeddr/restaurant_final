<?php

namespace App\Entity;

use App\Repository\OperationORepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OperationORepository::class)
 */
class OperationO
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
    private $IdOperation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $TypeOperation;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $AliasJrs;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $HeureAlias;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $CommandeJrs;

    /**
     * @ORM\Column(type="float")
     */
    private $SoldeAv;

    /**
     * @ORM\Column(type="float")
     */
    private $SoldeAp;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $DateOperation;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $HeureOperation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $IdAcheteur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $NomAcheteur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $IdSource;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $IdUser;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Borne;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Statut;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Statut2;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $Annuler;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $DateSys;

    /**
     * @ORM\ManyToOne(targetEntity=Carte::class, inversedBy="operationOs")
     */
    private $Carte;

    /**
     * @ORM\ManyToOne(targetEntity=CarteRepartition::class, inversedBy="operationOs")
     */
    private $Repartition;

    /**
     * @ORM\OneToMany(targetEntity=OperationLgO::class, mappedBy="Operation")
     */
    private $operationLgOs;

  

    public function __construct()
    {
        $this->Carte = new ArrayCollection();
        $this->Repartition = new ArrayCollection();
        $this->operationLgOs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdOperation(): ?string
    {
        return $this->IdOperation;
    }

    public function setIdOperation(?string $IdOperation): self
    {
        $this->IdOperation = $IdOperation;

        return $this;
    }

    public function getTypeOperation(): ?string
    {
        return $this->TypeOperation;
    }

    public function setTypeOperation(?string $TypeOperation): self
    {
        $this->TypeOperation = $TypeOperation;

        return $this;
    }

    public function getAliasJrs(): ?int
    {
        return $this->AliasJrs;
    }

    public function setAliasJrs(?int $AliasJrs): self
    {
        $this->AliasJrs = $AliasJrs;

        return $this;
    }

    public function getHeureAlias(): ?\DateTimeInterface
    {
        return $this->HeureAlias;
    }

    public function setHeureAlias(?\DateTimeInterface $HeureAlias): self
    {
        $this->HeureAlias = $HeureAlias;

        return $this;
    }

    public function getCommandeJrs(): ?int
    {
        return $this->CommandeJrs;
    }

    public function setCommandeJrs(?int $CommandeJrs): self
    {
        $this->CommandeJrs = $CommandeJrs;

        return $this;
    }

    public function getSoldeAv(): ?float
    {
        return $this->SoldeAv;
    }

    public function setSoldeAv(float $SoldeAv): self
    {
        $this->SoldeAv = $SoldeAv;

        return $this;
    }

    public function getSoldeAp(): ?float
    {
        return $this->SoldeAp;
    }

    public function setSoldeAp(float $SoldeAp): self
    {
        $this->SoldeAp = $SoldeAp;

        return $this;
    }

    public function getDateOperation(): ?\DateTimeInterface
    {
        return $this->DateOperation;
    }

    public function setDateOperation(?\DateTimeInterface $DateOperation): self
    {
        $this->DateOperation = $DateOperation;

        return $this;
    }

    public function getHeureOperation(): ?\DateTimeInterface
    {
        return $this->HeureOperation;
    }

    public function setHeureOperation(?\DateTimeInterface $HeureOperation): self
    {
        $this->HeureOperation = $HeureOperation;

        return $this;
    }

    public function getIdAcheteur(): ?string
    {
        return $this->IdAcheteur;
    }

    public function setIdAcheteur(?string $IdAcheteur): self
    {
        $this->IdAcheteur = $IdAcheteur;

        return $this;
    }

    public function getNomAcheteur(): ?string
    {
        return $this->NomAcheteur;
    }

    public function setNomAcheteur(?string $NomAcheteur): self
    {
        $this->NomAcheteur = $NomAcheteur;

        return $this;
    }

    public function getIdSource(): ?string
    {
        return $this->IdSource;
    }

    public function setIdSource(?string $IdSource): self
    {
        $this->IdSource = $IdSource;

        return $this;
    }

    public function getIdUser(): ?string
    {
        return $this->IdUser;
    }

    public function setIdUser(?string $IdUser): self
    {
        $this->IdUser = $IdUser;

        return $this;
    }

    public function getBorne(): ?string
    {
        return $this->Borne;
    }

    public function setBorne(?string $Borne): self
    {
        $this->Borne = $Borne;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->Statut;
    }

    public function setStatut(?string $Statut): self
    {
        $this->Statut = $Statut;

        return $this;
    }

    public function getStatut2(): ?string
    {
        return $this->Statut2;
    }

    public function setStatut2(?string $Statut2): self
    {
        $this->Statut2 = $Statut2;

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

    public function getDateSys(): ?\DateTimeInterface
    {
        return $this->DateSys;
    }

    public function setDateSys(?\DateTimeInterface $DateSys): self
    {
        $this->DateSys = $DateSys;

        return $this;
    }

    public function getCarte(): ?Carte
    {
        return $this->Carte;
    }

    public function setCarte(?Carte $Carte): self
    {
        $this->Carte = $Carte;

        return $this;
    }

    public function getRepartition(): ?CarteRepartition
    {
        return $this->Repartition;
    }

    public function setRepartition(?CarteRepartition $Repartition): self
    {
        $this->Repartition = $Repartition;

        return $this;
    }

    /**
     * @return Collection<int, OperationLgO>
     */
    public function getOperationLgOs(): Collection
    {
        return $this->operationLgOs;
    }

    public function addOperationLgO(OperationLgO $operationLgO): self
    {
        if (!$this->operationLgOs->contains($operationLgO)) {
            $this->operationLgOs[] = $operationLgO;
            $operationLgO->setOperation($this);
        }

        return $this;
    }

    public function removeOperationLgO(OperationLgO $operationLgO): self
    {
        if ($this->operationLgOs->removeElement($operationLgO)) {
            // set the owning side to null (unless already changed)
            if ($operationLgO->getOperation() === $this) {
                $operationLgO->setOperation(null);
            }
        }

        return $this;
    }

  



   
}
