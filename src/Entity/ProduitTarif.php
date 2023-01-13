<?php

namespace App\Entity;

use App\Repository\ProduitTarifRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity(repositoryClass=ProduitTarifRepository::class)
 */
class ProduitTarif
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $TarifTtc;

    /**
     * @ORM\Column(type="float")
     */
    private $Taux;

    /**
     * @ORM\Column(type="float")
     */
    private $TarifHt;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $Visib;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $DateSys;

    /**
     * @ORM\ManyToOne(targetEntity=Produit::class, inversedBy="produitTarifs")
     * @ORM\JoinColumn(onDelete="CASCADE") 
     */
    private $Produit;

    /**
     * @ORM\ManyToOne(targetEntity=TypeTarif::class, inversedBy="produitTarifs")
     */
    private $Tarif;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTarifTtc(): ?float
    {
        return $this->TarifTtc;
    }

    public function setTarifTtc(float $TarifTtc): self
    {
        $this->TarifTtc = $TarifTtc;

        return $this;
    }

    public function getTaux(): ?float
    {
        return $this->Taux;
    }

    public function setTaux(float $Taux): self
    {
        $this->Taux = $Taux;

        return $this;
    }

    public function getTarifHt(): ?float
    {
        return $this->TarifHt;
    }

    public function setTarifHt(float $TarifHt): self
    {
        $this->TarifHt = $TarifHt;

        return $this;
    }

    public function getVisib(): ?bool
    {
        return $this->Visib;
    }

    public function setVisib(?bool $Visib): self
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

    public function getProduit(): ?Produit
    {
        return $this->Produit;
    }

    public function setProduit(?Produit $Produit): self
    {
        $this->Produit = $Produit;

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
}
