<?php

namespace App\Entity;

use App\Repository\OperationLgORepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OperationLgORepository::class)
 */
class OperationLgO
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ligne;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $Acc;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $Qte;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $PrixU;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $TConvention;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $PrixTtc;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Taux;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $PrixHt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $NPage;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $DateSys;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $HeureSys;

    /**
     * @ORM\ManyToOne(targetEntity=OperationO::class, inversedBy="operationLgOs")
     */
    private $Operation;

    /**
     * @ORM\ManyToOne(targetEntity=Produit::class, inversedBy="operationLgOs")
     */
    private $Produit;

   

    public function __construct()
    {
        $this->Operation = new ArrayCollection();
        $this->Produit = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLigne(): ?int
    {
        return $this->ligne;
    }

    public function setLigne(?int $ligne): self
    {
        $this->ligne = $ligne;

        return $this;
    }

    public function getAcc(): ?bool
    {
        return $this->Acc;
    }

    public function setAcc(?bool $Acc): self
    {
        $this->Acc = $Acc;

        return $this;
    }

    public function getQte(): ?float
    {
        return $this->Qte;
    }

    public function setQte(?float $Qte): self
    {
        $this->Qte = $Qte;

        return $this;
    }

    public function getPrixU(): ?float
    {
        return $this->PrixU;
    }

    public function setPrixU(?float $PrixU): self
    {
        $this->PrixU = $PrixU;

        return $this;
    }

    public function getTConvention(): ?int
    {
        return $this->TConvention;
    }

    public function setTConvention(?int $TConvention): self
    {
        $this->TConvention = $TConvention;

        return $this;
    }

    public function getPrixTtc(): ?float
    {
        return $this->PrixTtc;
    }

    public function setPrixTtc(?float $PrixTtc): self
    {
        $this->PrixTtc = $PrixTtc;

        return $this;
    }

    public function getTaux(): ?int
    {
        return $this->Taux;
    }

    public function setTaux(?int $Taux): self
    {
        $this->Taux = $Taux;

        return $this;
    }

    public function getPrixHt(): ?float
    {
        return $this->PrixHt;
    }

    public function setPrixHt(?float $PrixHt): self
    {
        $this->PrixHt = $PrixHt;

        return $this;
    }

    public function getNPage(): ?int
    {
        return $this->NPage;
    }

    public function setNPage(?int $NPage): self
    {
        $this->NPage = $NPage;

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

    public function getHeureSys(): ?\DateTimeInterface
    {
        return $this->HeureSys;
    }

    public function setHeureSys(?\DateTimeInterface $HeureSys): self
    {
        $this->HeureSys = $HeureSys;

        return $this;
    }

    public function getOperation(): ?OperationO
    {
        return $this->Operation;
    }

    public function setOperation(?OperationO $Operation): self
    {
        $this->Operation = $Operation;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->Produit;
    }

    public function setProduit(?Produit $Produit): self
    {
        $this->Produit = $Produit;

        return $this;
    }

  
}
