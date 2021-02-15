<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StatusDiseaseRepository")
 */
class StatusDisease
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
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Disease")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Disease;

    /**
     * @ORM\Column(type="boolean")
     */
    private $beaten;

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


    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getDisease(): ?Disease
    {
        return $this->Disease;
    }

    public function setDisease(?Disease $Disease): self
    {
        $this->Disease = $Disease;

        return $this;
    }

    public function __toString()
    {
        return $this->getUser()->getUsername().' - '.$this->getDisease()->getName();
    }

    public function getBeaten(): ?bool
    {
        return $this->beaten;
    }

    public function setBeaten(bool $beaten): self
    {
        $this->beaten = $beaten;

        return $this;
    }
}
