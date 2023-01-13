<?php

namespace App\Entity;

use App\Entity\TypeTarif;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 */
class Produit
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
    private $IdProduit;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Produit;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $UniteVente;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $CodeBarre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Photo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $PhotoBorn;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $Ordre;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $AvoirAcc;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $Choix;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Imprimante;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $Visib;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $DateSys;

    /**
     * @ORM\ManyToOne(targetEntity=FamilleSousC::class, inversedBy="produits")
     */
    private $FamilleSousC;

    /**
     * @ORM\ManyToOne(targetEntity=TypeProduit::class, inversedBy="produits")
     */
    private $TypeProduit;

    /**
     * @ORM\OneToMany(targetEntity=ProduitTarif::class, mappedBy="Produit",orphanRemoval=true)
     */
    private $produitTarifs;

    /**
     * @ORM\OneToMany(targetEntity=CarteLg::class, mappedBy="Produit",orphanRemoval=true)
     * 
     */
    private $carteLgs;

    /**
     * @ORM\ManyToOne(targetEntity=OperationLgO::class, inversedBy="Produit")
     */
    private $operationLgO;

    /**
     * @ORM\OneToMany(targetEntity=OperationLgO::class, mappedBy="Produit")
     */
    private $operationLgOs;

    public function __construct()
    {
        $this->produitTarifs = new ArrayCollection();
        $this->carteLgs = new ArrayCollection();
        $this->operationLgOs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdProduit(): ?string
    {
        return $this->IdProduit;
    }

    public function setIdProduit(string $IdProduit): self
    {
        $this->IdProduit = $IdProduit;

        return $this;
    }

    public function getProduit(): ?string
    {
        return $this->Produit;
    }

    public function setProduit(string $Produit): self
    {
        $this->Produit = $Produit;

        return $this;
    }

    public function getUniteVente(): ?string
    {
        return $this->UniteVente;
    }

    public function setUniteVente(?string $UniteVente): self
    {
        $this->UniteVente = $UniteVente;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getCodeBarre(): ?string
    {
        return $this->CodeBarre;
    }

    public function setCodeBarre(?string $CodeBarre): self
    {
        $this->CodeBarre = $CodeBarre;

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

    public function getOrdre(): ?bool
    {
        return $this->Ordre;
    }

    public function setOrdre(?bool $Ordre): self
    {
        $this->Ordre = $Ordre;

        return $this;
    }

    public function getAvoirAcc(): ?bool
    {
        return $this->AvoirAcc;
    }

    public function setAvoirAcc(?bool $AvoirAcc): self
    {
        $this->AvoirAcc = $AvoirAcc;

        return $this;
    }

    public function getChoix(): ?bool
    {
        return $this->Choix;
    }

    public function setChoix(?bool $Choix): self
    {
        $this->Choix = $Choix;

        return $this;
    }

    public function getImprimante(): ?string
    {
        return $this->Imprimante;
    }

    public function setImprimante(?string $Imprimante): self
    {
        $this->Imprimante = $Imprimante;

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

    public function getFamilleSousC(): ?FamilleSousC
    {
        return $this->FamilleSousC;
    }

    public function setFamilleSousC(?FamilleSousC $FamilleSousC): self
    {
        $this->FamilleSousC = $FamilleSousC;

        return $this;
    }

    public function getTypeProduit(): ?TypeProduit
    {
        return $this->TypeProduit;
    }

    public function setTypeProduit(?TypeProduit $TypeProduit): self
    {
        $this->TypeProduit = $TypeProduit;

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
            $produitTarif->setProduit($this);
        }

        return $this;
    }

    public function removeProduitTarif(ProduitTarif $produitTarif): self
    {
        if ($this->produitTarifs->removeElement($produitTarif)) {
            // set the owning side to null (unless already changed)
            if ($produitTarif->getProduit() === $this) {
                $produitTarif->setProduit(null);
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
            $carteLg->setProduit($this);
        }

        return $this;
    }

    public function removeCarteLg(CarteLg $carteLg): self
    {
        if ($this->carteLgs->removeElement($carteLg)) {
            // set the owning side to null (unless already changed)
            if ($carteLg->getProduit() === $this) {
                $carteLg->setProduit(null);
            }
        }

        return $this;
    }

    public function getOperationLgO(): ?OperationLgO
    {
        return $this->operationLgO;
    }

    public function setOperationLgO(?OperationLgO $operationLgO): self
    {
        $this->operationLgO = $operationLgO;

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
            $operationLgO->setProduit($this);
        }

        return $this;
    }

    public function removeOperationLgO(OperationLgO $operationLgO): self
    {
        if ($this->operationLgOs->removeElement($operationLgO)) {
            // set the owning side to null (unless already changed)
            if ($operationLgO->getProduit() === $this) {
                $operationLgO->setProduit(null);
            }
        }

        return $this;
    }
}
