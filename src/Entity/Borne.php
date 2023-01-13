<?php

namespace App\Entity;

use App\Repository\BorneRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BorneRepository::class)
 */
class Borne
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
    private $Machine_Alias;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $IP;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Sn;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Port;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMachineAlias(): ?string
    {
        return $this->Machine_Alias;
    }

    public function setMachineAlias(?string $Machine_Alias): self
    {
        $this->Machine_Alias = $Machine_Alias;

        return $this;
    }

    public function getIP(): ?string
    {
        return $this->IP;
    }

    public function setIP(?string $IP): self
    {
        $this->IP = $IP;

        return $this;
    }

    public function getSn(): ?string
    {
        return $this->Sn;
    }

    public function setSn(?string $Sn): self
    {
        $this->Sn = $Sn;

        return $this;
    }

    public function getPort(): ?string
    {
        return $this->Port;
    }

    public function setPort(?string $Port): self
    {
        $this->Port = $Port;

        return $this;
    }
}
