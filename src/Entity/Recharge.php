<?php

namespace App\Entity;

use App\Repository\RechargeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RechargeRepository::class)
 */
class Recharge
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
    private $IdRecharge;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $TypeRecharge;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $IdConsommateur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Consommateur;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $DateRecharge;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $HeureRecharge;

    /**
     * @ORM\Column(type="integer")
     */
    private $Montant;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Statut;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $DateSys;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdRecharge(): ?string
    {
        return $this->IdRecharge;
    }

    public function setIdRecharge(?string $IdRecharge): self
    {
        $this->IdRecharge = $IdRecharge;

        return $this;
    }

    public function getTypeRecharge(): ?string
    {
        return $this->TypeRecharge;
    }

    public function setTypeRecharge(?string $TypeRecharge): self
    {
        $this->TypeRecharge = $TypeRecharge;

        return $this;
    }

    public function getIdConsommateur(): ?string
    {
        return $this->IdConsommateur;
    }

    public function setIdConsommateur(?string $IdConsommateur): self
    {
        $this->IdConsommateur = $IdConsommateur;

        return $this;
    }

    public function getConsommateur(): ?string
    {
        return $this->Consommateur;
    }

    public function setConsommateur(?string $Consommateur): self
    {
        $this->Consommateur = $Consommateur;

        return $this;
    }

    public function getDateRecharge(): ?\DateTimeInterface
    {
        return $this->DateRecharge;
    }

    public function setDateRecharge(?\DateTimeInterface $DateRecharge): self
    {
        $this->DateRecharge = $DateRecharge;

        return $this;
    }

    public function getHeureRecharge(): ?\DateTimeInterface
    {
        return $this->HeureRecharge;
    }

    public function setHeureRecharge(?\DateTimeInterface $HeureRecharge): self
    {
        $this->HeureRecharge = $HeureRecharge;

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->Montant;
    }

    public function setMontant(int $Montant): self
    {
        $this->Montant = $Montant;

        return $this;
    }

    public function getStatut(): ?bool
    {
        return $this->Statut;
    }

    public function setStatut(bool $Statut): self
    {
        $this->Statut = $Statut;

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
}
