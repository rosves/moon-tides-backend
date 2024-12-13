<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
#[ORM\Entity(repositoryClass: UsersRepository::class)] // Cette annotation indique que cette classe est une entité Doctrine et que la classe UsersRepository gère les accès aux données.
#[ORM\HasLifecycleCallbacks] // Cette annotation permet l'utilisation de callbacks de cycle de vie, par exemple pour définir la date de création de l'utilisateur avant qu'il ne soit enregistré.
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])] // Cette contrainte assure que l'email de l'utilisateur est unique dans la base de données.
class Users implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id] // Cette annotation marque l'attribut id comme clé primaire de l'entité.
    #[ORM\GeneratedValue] // Cette annotation indique que la valeur de l'id sera générée automatiquement par la base de données.
    #[ORM\Column] // Cette annotation indique que cet attribut sera mappé sur une colonne dans la base de données.
    #[Groups('user:users')]
    private ?int $id = null; // L'identifiant unique de l'utilisateur.

    #[ORM\Column(length: 180)] // L'annotation définit une colonne de longueur 180 pour l'email de l'utilisateur.
    #[Groups('user:users')]
    private ?string $email = null; // L'email de l'utilisateur. Il doit être unique dans la base de données.

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column] // Cette annotation indique que l'attribut sera mappé sur une colonne dans la base de données.
    #[Groups('user:users')]
    private array $roles = []; // Rôle(s) de l'utilisateur (ex. 'ROLE_USER', 'ROLE_ADMIN').

    /**
     * @var string The hashed password
     */
    #[ORM\Column] // Cette annotation définit une colonne dans la base de données pour le mot de passe.
    private ?string $password = null; // Le mot de passe haché de l'utilisateur.

    #[ORM\Column(length: 100)] // La colonne "username" a une longueur maximale de 100 caractères.
    #[Groups('user:users')]
    private ?string $username = null; // Le nom d'utilisateur, souvent affiché comme alias de l'utilisateur.

    #[ORM\Column] // Déclare une colonne pour la date de création de l'utilisateur.
    private ?\DateTimeImmutable $date_creation = null; // La date de création du compte de l'utilisateur.

    #[ORM\OneToOne(cascade: ['persist', 'remove'])] // La relation OneToOne signifie qu'un utilisateur possède exactement un journal.
    #[ORM\JoinColumn(nullable: false)] // La colonne "journal" ne peut pas être nulle.
    private ?Journal $journal = null; // Le journal associé à l'utilisateur.

    /**
     * @var Collection<int, Notify>
     */
    #[ORM\OneToMany(targetEntity: Notify::class, mappedBy: 'user')] // Relation OneToMany avec Notify, un utilisateur peut avoir plusieurs notifications.
    private Collection $notify; // Les notifications associées à l'utilisateur.

    #[ORM\OneToOne(cascade: ['persist', 'remove'])] // La relation OneToOne avec MoonNotification, permettant de lier un utilisateur à ses préférences de notification liées aux phases de la Lune.
    #[ORM\JoinColumn(nullable: false)] // Cette colonne ne peut pas être nulle.
    private ?MoonNotification $notifymoon = null; // Les préférences de notification liées aux phases lunaires.

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'users')] // Relation OneToMany avec Comment, un utilisateur peut avoir plusieurs commentaires associés.
    private Collection $comment; // Les commentaires de l'utilisateur.

    public function __construct()
    {
        $this->notify = new ArrayCollection(); // Initialisation d'une collection vide pour les notifications.
        $this->comment = new ArrayCollection(); // Initialisation d'une collection vide pour les commentaires.
    }

    public function getId(): ?int
    {
        return $this->id; // Retourne l'identifiant unique de l'utilisateur.
    }

    public function getEmail(): ?string
    {
        return $this->email; // Retourne l'email de l'utilisateur.
    }

    public function setEmail(string $email): static
    {
        $this->email = $email; // Définit l'email de l'utilisateur.
        return $this; // Retourne l'objet courant pour permettre un chaînage de méthodes.
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email; // Retourne l'email comme identifiant unique de l'utilisateur pour l'authentification.
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles; // Récupère les rôles de l'utilisateur.
        $roles[] = 'ROLE_USER'; // Ajoute le rôle par défaut "ROLE_USER" si aucun autre rôle n'est défini.
        return array_unique($roles); // Retourne les rôles uniques.
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles; // Définit les rôles de l'utilisateur.
        return $this; // Retourne l'objet courant pour un chaînage fluide.
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password; // Retourne le mot de passe haché de l'utilisateur.
    }

    public function setPassword(string $password): static
    {
        $this->password = $password; // Définit le mot de passe haché de l'utilisateur.
        return $this; // Retourne l'objet courant pour un chaînage fluide.
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // Méthode qui peut être utilisée pour effacer les données sensibles (non utilisé ici car on utilise des mots de passe hachés).
    }

    public function getUsername(): ?string
    {
        return $this->username; // Retourne le nom d'utilisateur.
    }

    public function setUsername(string $username): static
    {
        $this->username = $username; // Définit le nom d'utilisateur.
        return $this; // Retourne l'objet courant pour un chaînage fluide.
    }

    public function getDateCreation(): ?\DateTimeImmutable
    {
        return $this->date_creation; // Retourne la date de création de l'utilisateur.
    }

    #[ORM\PrePersist] // Cette annotation marque la méthode pour être appelée avant l'insertion de l'entité dans la base de données.
    public function setDateCreation()
    {
        $this->date_creation = new \DateTimeImmutable(); // Définit la date de création comme la date et l'heure actuelles avant l'enregistrement.
        return $this; // Retourne l'objet courant pour un chaînage fluide.
    }

    public function getJournal(): ?Journal
    {
        return $this->journal; // Retourne l'objet Journal associé à l'utilisateur.
    }

    public function setJournal(Journal $Journal): static
    {
        $this->journal = $Journal; // Définit le journal de l'utilisateur.
        return $this; // Retourne l'objet courant pour un chaînage fluide.
    }

    /**
     * @return Collection<int, Notify>
     */
    public function getNotify(): Collection
    {
        return $this->notify; // Retourne la collection des notifications associées à l'utilisateur.
    }

    public function addNotify(Notify $notify): static
    {
        if (!$this->notify->contains($notify)) { // Si la notification n'est pas déjà présente dans la collection...
            $this->notify->add($notify); // Ajoute la notification.
            $notify->setUser($this); // Définit l'utilisateur de cette notification.
        }
        return $this; // Retourne l'objet courant pour un chaînage fluide.
    }

    public function removeNotify(Notify $notify): static
    {
        if ($this->notify->removeElement($notify)) { // Si la notification est présente dans la collection...
            // Assure que la notification n'a plus cet utilisateur comme propriétaire.
            if ($notify->getUser() === $this) {
                $notify->setUser(null); 
            }
        }
        return $this; // Retourne l'objet courant pour un chaînage fluide.
    }

    public function getNotifymoon(): ?MoonNotification
    {
        return $this->notifymoon; // Retourne les préférences de notification liées à la Lune.
    }

    public function setNotifymoon(MoonNotification $notifymoon): static
    {
        $this->notifymoon = $notifymoon; // Définit les préférences de notification liées à la Lune.
        return $this; // Retourne l'objet courant pour un chaînage fluide.
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComment(): Collection
    {
        return $this->comment; // Retourne la collection des commentaires de l'utilisateur.
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comment->contains($comment)) { // Si le commentaire n'est pas déjà présent...
            $this->comment->add($comment); // Ajoute le commentaire à l'utilisateur.
            $comment->setUsers($this); // Définit l'utilisateur de ce commentaire.
        }
        return $this; // Retourne l'objet courant pour un chaînage fluide.
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comment->removeElement($comment)) { // Si le commentaire est présent...
            if ($comment->getUsers() === $this) {
                $comment->setUsers(null); // Supprime la référence à l'utilisateur pour ce commentaire.
            }
        }
        return $this; // Retourne l'objet courant pour un chaînage fluide.
    }
}
