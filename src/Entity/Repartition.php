<?php

namespace App\Entity;

use App\Repository\RepartitionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RepartitionRepository::class)
 */
class Repartition
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
    private $Repartition;

    /**
     * @ORM\Column(type="datetime")
     */
    private $HeureDebut;

    /**
     * @ORM\Column(type="datetime")
     */
    private $HeureFin;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Ordre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Image;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getHeureDebut(): ?\DateTimeInterface
    {
        return $this->HeureDebut;
    }

    public function setHeureDebut(\DateTimeInterface $HeureDebut): self
    {
        $this->HeureDebut = $HeureDebut;

        return $this;
    }

    public function getHeureFin(): ?\DateTimeInterface
    {
        return $this->HeureFin;
    }

    public function setHeureFin(\DateTimeInterface $HeureFin): self
    {
        $this->HeureFin = $HeureFin;

        return $this;
    }

    public function getOrdre(): ?int
    {
        return $this->Ordre;
    }

    public function setOrdre(?int $Ordre): self
    {
        $this->Ordre = $Ordre;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->Image;
    }

    public function setImage(?string $Image): self
    {
        $this->Image = $Image;

        return $this;
    }
}
