<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActionUserRepository")
 */
class ActionUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\GameUser")
     * @ORM\JoinColumn(nullable=false)
     */
    private $GameUser;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Weapon")
     */
    private $Weapon;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $action;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\GameUser")
     */
    private $Target;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGameUser(): ?GameUser
    {
        return $this->GameUser;
    }

    public function setGameUser(?GameUser $GameUser): self
    {
        $this->GameUser = $GameUser;

        return $this;
    }

    public function getWeapon(): ?Weapon
    {
        return $this->Weapon;
    }

    public function setWeapon(?Weapon $Weapon): self
    {
        $this->Weapon = $Weapon;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(string $action): self
    {
        $this->action = $action;

        return $this;
    }

    public function getTarget(): ?GameUser
    {
        return $this->Target;
    }

    public function setTarget(?GameUser $Target): self
    {
        $this->Target = $Target;

        return $this;
    }
}
