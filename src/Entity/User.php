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
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\OneToOne(inversedBy: 'user', targetEntity: Admin::class, cascade: ['persist', 'remove'])]
    private $admin;

    #[ORM\OneToOne(inversedBy: 'user', targetEntity: Student::class, cascade: ['persist', 'remove'])]
    private $student;

    #[ORM\OneToOne(inversedBy: 'user', targetEntity: Professor::class, cascade: ['persist', 'remove'])]
    private $professor;

    #[ORM\Column(type: 'boolean')]
    private $isProfessor = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
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

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function setIsProfessor (bool $isProfessor) {
        $this->isProfessor = $isProfessor;
        if ($this->roles === ["ROLE_PROFESSOR"]) {
            $this->isProfessor = true;
        }
        if ($isProfessor) {
            return $this->roles[] = "ROLE_PROFESSOR";
        }
        if (!$isProfessor) {
            return $this->roles = array_diff($this->roles, array("ROLE_PROFESSOR"));
        }
        return $this->isProfessor;
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

    public function getAdmin(): ?Admin
    {
        return $this->admin;
    }

    public function setAdmin(?Admin $admin): self
    {
        $this->admin = $admin;

        return $this;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): self
    {
        $this->student = $student;

        return $this;
    }

    public function getProfessor(): ?Professor
    {
        return $this->professor;
    }

    public function setProfessor(?Professor $professor): self
    {
        $this->professor = $professor;
        return $this;
    }

    public function getIsProfessor(): ?bool
    {
        return $this->isProfessor;
    }

    public function __toString(): string
    {
        if ($this->professor === $this->id){
        return $this->email;
        }
        return 'ma bite';
    }


}
