<?php

namespace App\Entity;

use App\Repository\CarteLgRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;


/**
 * @ORM\Entity(repositoryClass=CarteLgRepository::class)
 */
class CarteLg
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
    private $IdCarteLg;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $StockCarte;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Unite;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $StockCmd;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $StockCarteTemp;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $StockReste;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $DateSys;

    /**
     * @ORM\ManyToOne(targetEntity=CarteRepartition::class, inversedBy="carteLgs")
     *  @JoinColumn(onDelete="CASCADE")
     */
    private $Repartition;

    /**
     * @ORM\ManyToOne(targetEntity=Carte::class, inversedBy="carteLgs")
     * @JoinColumn(onDelete="CASCADE")
     */
    private $Carte;

    /**
     * @ORM\ManyToOne(targetEntity=Produit::class, inversedBy="carteLgs")
     * @ORM\JoinColumn(onDelete="CASCADE") 
     */
    private $Produit;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCarteLg(): ?string
    {
        return $this->IdCarteLg;
    }

    public function setIdCarteLg(string $IdCarteLg): self
    {
        $this->IdCarteLg = $IdCarteLg;

        return $this;
    }

    public function getStockCarte(): ?int
    {
        return $this->StockCarte;
    }

    public function setStockCarte(?int $StockCarte): self
    {
        $this->StockCarte = $StockCarte;

        return $this;
    }

    public function getUnite(): ?string
    {
        return $this->Unite;
    }

    public function setUnite(?string $Unite): self
    {
        $this->Unite = $Unite;

        return $this;
    }

    public function getStockCmd(): ?int
    {
        return $this->StockCmd;
    }

    public function setStockCmd(?int $StockCmd): self
    {
        $this->StockCmd = $StockCmd;

        return $this;
    }

    public function getStockCarteTemp(): ?int
    {
        return $this->StockCarteTemp;
    }

    public function setStockCarteTemp(?int $StockCarteTemp): self
    {
        $this->StockCarteTemp = $StockCarteTemp;

        return $this;
    }

    public function getStockReste(): ?int
    {
        return $this->StockReste;
    }

    public function setStockReste(?int $StockReste): self
    {
        $this->StockReste = $StockReste;

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

    public function getRepartition(): ?CarteRepartition
    {
        return $this->Repartition;
    }

    public function setRepartition(?CarteRepartition $Repartition): self
    {
        $this->Repartition = $Repartition;

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
