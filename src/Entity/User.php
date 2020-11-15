<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @UniqueEntity("username")
 *
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    const MAX_HEALTH = 100;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank
     *
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="array")
     */
    private $roles = [];

    /**
     * @Assert\Range(
     *      min = 0,
     *      max = 100,
     *      minMessage = "You must be at least {{ limit }} health",
     *      maxMessage = "You cannot have more than {{ limit }} health"
     * )
     *
     * @ORM\Column(type="integer")
     */
    private $health;


    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;


    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function addRole(string $role): self{
        if(!in_array($role, $this->roles)){
            $this->roles[] = $role;
        }
        return $this;
    }

    public function removeRole(string $role): self{
        if(in_array($role, $this->roles)){
            unset($this->roles[array_keys($this->roles, $role)[0]]);
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHealth(): ?int
    {
        return $this->health;
    }

    /**
     * @param mixed $health
     */
    public function setHealth(int $health): void
    {
        $this->health = $health;
    }

    /**
     * @return bool
     */
    public function getEnabled(): ?bool
    {
        return ($this->health > 0 ? true : false);
    }


    /**
     * @return mixed
     */
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function __toString()
    {
        return $this->getUsername();
    }
}
