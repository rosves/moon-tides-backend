<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class Users implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 100)]
    private ?string $username = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date_creation = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Journal $Journal = null;


    /**
     * @var Collection<int, Notify>
     */
    #[ORM\OneToMany(targetEntity: Notify::class, mappedBy: 'user')]
    private Collection $notify;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?MoonNotification $notifymoon = null;

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'users')]
    private Collection $comment;

    public function __construct()
    {
        $this->notify = new ArrayCollection();
        $this->comment = new ArrayCollection();
    }

    public function getId(): ?int
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
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeImmutable
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTimeImmutable $date_creation): static
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    public function getJournal(): ?Journal
    {
        return $this->Journal;
    }

    public function setJournal(Journal $Journal): static
    {
        $this->Journal = $Journal;

        return $this;
    }


    /**
     * @return Collection<int, Notify>
     */
    public function getNotify(): Collection
    {
        return $this->notify;
    }

    public function addNotify(Notify $notify): static
    {
        if (!$this->notify->contains($notify)) {
            $this->notify->add($notify);
            $notify->setUser($this);
        }

        return $this;
    }

    public function removeNotify(Notify $notify): static
    {
        if ($this->notify->removeElement($notify)) {
            // set the owning side to null (unless already changed)
            if ($notify->getUser() === $this) {
                $notify->setUser(null);
            }
        }

        return $this;
    }

    public function getNotifymoon(): ?MoonNotification
    {
        return $this->notifymoon;
    }

    public function setNotifymoon(MoonNotification $notifymoon): static
    {
        $this->notifymoon = $notifymoon;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComment(): Collection
    {
        return $this->comment;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comment->contains($comment)) {
            $this->comment->add($comment);
            $comment->setUsers($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comment->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getUsers() === $this) {
                $comment->setUsers(null);
            }
        }

        return $this;
    }
}
