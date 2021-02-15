<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TreatmentRepository")
 */
class Treatment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $dosage;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Disease")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Disease;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Hospital", inversedBy="Treatments")
     */
    private $Hospitals;

    public function __construct()
    {
        $this->Hospitals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDosage(): ?int
    {
        return $this->dosage;
    }

    public function setDosage(int $dosage): self
    {
        $this->dosage = $dosage;

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

    /**
     * @return Collection|Hospital[]
     */
    public function getHospitals(): Collection
    {
        return $this->Hospitals;
    }

    public function addHospital(Hospital $hospital): self
    {
        if (!$this->Hospitals->contains($hospital)) {
            $this->Hospitals[] = $hospital;
        }

        return $this;
    }

    public function removeHospital(Hospital $hospital): self
    {
        if ($this->Hospitals->contains($hospital)) {
            $this->Hospitals->removeElement($hospital);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
