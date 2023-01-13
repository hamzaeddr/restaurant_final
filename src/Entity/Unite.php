<?php

namespace App\Entity;

use App\Repository\UniteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UniteRepository::class)
 */
class Unite
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
    private $Unite;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Obs;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUnite(): ?string
    {
        return $this->Unite;
    }

    public function setUnite(string $Unite): self
    {
        $this->Unite = $Unite;

        return $this;
    }

    public function getObs(): ?string
    {
        return $this->Obs;
    }

    public function setObs(string $Obs): self
    {
        $this->Obs = $Obs;

        return $this;
    }
}
