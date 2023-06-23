<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Docteur $docteur = null;

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Acceuil $acceuil = null;
    
    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Responsable $responsable = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        return array_unique($this->roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }
    
    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getDocteur(): ?Docteur
    {
        return $this->docteur;
    }

    public function setDocteur(?Docteur $docteur): self
    {
        // unset the owning side of the relation if necessary
        if ($docteur === null && $this->docteur !== null) {
            $this->docteur->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($docteur !== null && $docteur->getUser() !== $this) {
            $docteur->setUser($this);
        }

        $this->docteur = $docteur;

        return $this;
    }

    public function getAcceuil(): ?Acceuil
    {
        return $this->acceuil;
    }

    public function setAcceuil(?Acceuil $acceuil): self
    {
        // unset the owning side of the relation if necessary
        if ($acceuil === null && $this->acceuil !== null) {
            $this->acceuil->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($acceuil !== null && $acceuil->getUser() !== $this) {
            $acceuil->setUser($this);
        }

        $this->acceuil = $acceuil;

        return $this;
    }
    
    public function getResponsable(): ?Responsable
    {
        return $this->acceuil;
    }

    public function setResponsable(?Responsable $responsable): self
    {
        // unset the owning side of the relation if necessary
        if ($responsable === null && $this->responsable !== null) {
            $this->responsable->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($responsable !== null && $responsable->getUser() !== $this) {
            $responsable->setUser($this);
        }

        $this->responsable = $responsable;

        return $this;
    }
}
