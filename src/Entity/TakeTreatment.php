<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TakeTreatmentRepository")
 */
class TakeTreatment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="boolean")
     */
    private $fail = false;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Treatment")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Traitment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\StatusDisease")
     * @ORM\JoinColumn(nullable=false)
     */
    private $StatusDisease;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getFail(): ?bool
    {
        return $this->fail;
    }

    public function setFail(bool $fail): self
    {
        $this->fail = $fail;

        return $this;
    }


    public function getTraitment(): ?Treatment
    {
        return $this->Traitment;
    }

    public function setTraitment(?Treatment $Traitment): self
    {
        $this->Traitment = $Traitment;

        return $this;
    }

    public function getStatusDisease(): ?StatusDisease
    {
        return $this->StatusDisease;
    }

    public function setStatusDisease(?StatusDisease $StatusDisease): self
    {
        $this->StatusDisease = $StatusDisease;

        return $this;
    }
}
