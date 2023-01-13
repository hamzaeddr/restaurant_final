<?php

namespace App\Entity;

use App\Repository\CarteRepartitionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CarteRepartitionRepository::class)
 */
class CarteRepartition
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
    private $IdRepartition;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Repartition;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $Heure;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Pax;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $Facturer;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $DateSys;

    /**
     * @ORM\ManyToOne(targetEntity=Carte::class, inversedBy="carteRepartitions")
     * @JoinColumn(onDelete="CASCADE")
     */
    private $Carte;

    /**
     * @ORM\OneToMany(targetEntity=CarteLg::class, mappedBy="Repartition,orphanRemoval=true")
     */
    private $carteLgs;

    /**
     * @ORM\OneToMany(targetEntity=OperationO::class, mappedBy="Repartition")
     */
    private $operationOs;

    
   

    public function __construct()
    {
        $this->carteLgs = new ArrayCollection();
        $this->operationOs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdRepartition(): ?string
    {
        return $this->IdRepartition;
    }

    public function setIdRepartition(string $IdRepartition): self
    {
        $this->IdRepartition = $IdRepartition;

        return $this;
    }

    public function getRepartition(): ?string
    {
        return $this->Repartition;
    }

    public function setRepartition(string $Repartition): self
    {
        $this->Repartition = $Repartition;

        return $this;
    }

    public function getHeure(): ?\DateTimeInterface
    {
        return $this->Heure;
    }

    public function setHeure(?\DateTimeInterface $Heure): self
    {
        $this->Heure = $Heure;

        return $this;
    }

    public function getPax(): ?int
    {
        return $this->Pax;
    }

    public function setPax(?int $Pax): self
    {
        $this->Pax = $Pax;

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
            $carteLg->setRepartition($this);
        }

        return $this;
    }

    public function removeCarteLg(CarteLg $carteLg): self
    {
        if ($this->carteLgs->removeElement($carteLg)) {
            // set the owning side to null (unless already changed)
            if ($carteLg->getRepartition() === $this) {
                $carteLg->setRepartition(null);
            }
        }

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
            $operationO->setRepartition($this);
        }

        return $this;
    }

    public function removeOperationO(OperationO $operationO): self
    {
        if ($this->operationOs->removeElement($operationO)) {
            // set the owning side to null (unless already changed)
            if ($operationO->getRepartition() === $this) {
                $operationO->setRepartition(null);
            }
        }

        return $this;
    }

}
