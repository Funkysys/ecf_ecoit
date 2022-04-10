<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $firstname;

    #[ORM\Column(type: 'string', length: 255)]
    private $lastname;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $age;

    #[ORM\ManyToMany(targetEntity: Formation::class, inversedBy: 'students')]
    private $formations_followed;

    #[ORM\OneToMany(mappedBy: 'student', targetEntity: Comment::class)]
    private $comments;

    #[ORM\OneToMany(mappedBy: 'student', targetEntity: Answer::class)]
    private $answers;

    public function __construct()
    {
        $this->formations_followed = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->answers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): self
    {
        $this->age = $age;

        return $this;
    }

    /**
     * @return Collection<int, Formation>
     */
    public function getFormationsFollowed(): Collection
    {
        return $this->formations_followed;
    }

    public function addFormationsFollowed(Formation $formationsFollowed): self
    {
        if (!$this->formations_followed->contains($formationsFollowed)) {
            $this->formations_followed[] = $formationsFollowed;
        }

        return $this;
    }

    public function removeFormationsFollowed(Formation $formationsFollowed): self
    {
        $this->formations_followed->removeElement($formationsFollowed);

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setStudent($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getStudent() === $this) {
                $comment->setStudent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Answer>
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answer $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers[] = $answer;
            $answer->setStudent($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->answers->removeElement($answer)) {
            // set the owning side to null (unless already changed)
            if ($answer->getStudent() === $this) {
                $answer->setStudent(null);
            }
        }

        return $this;
    }
}
