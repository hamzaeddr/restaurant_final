<?php

namespace App\Entity;

use App\Repository\CheckBorneRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CheckBorneRepository::class)
 */
class CheckBorne
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
    private $userid;

    /**
     * @ORM\Column(type="datetime")
     */
    private $Checktime;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sn;

    /**
     * @ORM\ManyToOne(targetEntity=Borne::class)
     */
    private $Borne;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserid(): ?string
    {
        return $this->userid;
    }

    public function setUserid(?string $userid): self
    {
        $this->userid = $userid;

        return $this;
    }

    public function getChecktime(): ?\DateTimeInterface
    {
        return $this->Checktime;
    }

    public function setChecktime(\DateTimeInterface $Checktime): self
    {
        $this->Checktime = $Checktime;

        return $this;
    }

    public function getSn(): ?string
    {
        return $this->sn;
    }

    public function setSn(string $sn): self
    {
        $this->sn = $sn;

        return $this;
    }

    public function getBorne(): ?Borne
    {
        return $this->Borne;
    }

    public function setBorne(?Borne $Borne): self
    {
        $this->Borne = $Borne;

        return $this;
    }
}
