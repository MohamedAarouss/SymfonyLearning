<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HospitalRepository")
 */
class Hospital
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
     * @ORM\ManyToMany(targetEntity="App\Entity\Treatment", mappedBy="Hospitals")
     */
    private $Treatments;

    public function __construct()
    {
        $this->Treatments = new ArrayCollection();
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

    /**
     * @return Collection|Treatment[]
     */
    public function getTreatments(): Collection
    {
        return $this->Treatments;
    }

    public function addTreatment(Treatment $treatment): self
    {
        if (!$this->Treatments->contains($treatment)) {
            $this->Treatments[] = $treatment;
            $treatment->addHospital($this);
        }

        return $this;
    }

    public function removeTreatment(Treatment $treatment): self
    {
        if ($this->Treatments->contains($treatment)) {
            $this->Treatments->removeElement($treatment);
            $treatment->removeHospital($this);
        }

        return $this;
    }
}
