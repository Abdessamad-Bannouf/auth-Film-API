<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Serializer\ExclusionPolicy("ALL")
 */
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(unique: true)]
    private ?string  $id = null;

    /**
     * @Serializer\Expose
     * @Serializer\Groups({"user:add", "user:single", "user:put"})
     */
    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Email(
        message: 'L\'email {{ value }} n\'est pas un email valide.',
    )]
    private ?string $email = null;

    /**
     * @Serializer\Expose
     * @Serializer\Groups({"user:add", "user:single", "user:put"})
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     * @Serializer\Expose
     * @Serializer\Groups({"user:add", "user:single", "user:put"})
     */
    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\PasswordStrength]
    private ?string $password = null;

    public function __construct()
    {
        $this->id = Uuid::v4();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
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

    public function setRoles(array $roles): static
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

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
