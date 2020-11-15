<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use App\Validator\Constraints as AssertApp;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WeaponRepository")
 *
 * @AssertApp\ConstraintsUniqueWeaponLegendary
 */
class Weapon
{
    const MAX_AMMUNITION = 30;

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
     *
     * @Assert\Range(
     *      min = 0,
     *      max = 30,
     *      minMessage = "You must be at least {{ limit }} ammmunition",
     *      maxMessage = "You cannot have more than {{ limit }} ammunition"
     * )
     */
    private $ammunition;

    /**
     * @ORM\Column(type="boolean")
     */
    private $inHand;

    /**
     * @ORM\Column(type="integer")
     */
    private $scarcity;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $User;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\WeaponType")
     * @ORM\JoinColumn(nullable=false)
     */
    private $WeaponType;

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

    public function getAmmunition(): ?int
    {
        return $this->ammunition;
    }

    public function setAmmunition(int $ammunition): self
    {
        $this->ammunition = $ammunition;

        return $this;
    }

    public function getInHand(): ?bool
    {
        return $this->inHand;
    }

    public function setInHand(bool $inHand): self
    {
        $this->inHand = $inHand;

        return $this;
    }

    public function getScarcity(): ?int
    {
        return $this->scarcity;
    }

    public function setScarcity(int $scarcity): self
    {
        $this->scarcity = $scarcity;

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

    public function getWeaponType(): ?WeaponType
    {
        return $this->WeaponType;
    }

    public function setWeaponType(?WeaponType $WeaponType): self
    {
        $this->WeaponType = $WeaponType;

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }
}
