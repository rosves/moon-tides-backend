<?php

namespace App\Entity;

use App\Repository\ArticlesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticlesRepository::class)] // Déclare cette classe comme une entité et spécifie le repository associé
class Articles
{
    #[ORM\Id] // Spécifie que ce champ est la clé primaire de l'entité
    #[ORM\GeneratedValue] // Spécifie que la valeur de l'ID est générée automatiquement
    #[ORM\Column] // Déclare une colonne dans la base de données
    private ?int $id = null; // Propriété ID de l'entité Articles

    #[ORM\Column(length: 100)] // Déclare une colonne de type string avec une longueur maximale de 100 caractères
    private ?string $title = null; // Propriété du titre de l'article

    #[ORM\Column(type: Types::TEXT)] // Déclare une colonne de type texte pour le contenu de l'article
    private ?string $content = null; // Propriété du contenu de l'article

    #[ORM\Column] // Déclare une colonne de type date pour la date de publication
    private ?\DateTimeImmutable $publication_date = null; // Propriété de la date de publication

    /**
     * @var Collection<int, Comment> // Déclare une collection d'objets Comment associée à cet article
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'articles')] // Relation OneToMany avec l'entité Comment
    private Collection $comment; // Propriété contenant les commentaires associés à cet article

    // Constructeur de la classe, initialise la collection de commentaires
    public function __construct()
    {
        $this->comment = new ArrayCollection(); // Initialise la collection pour stocker les commentaires
    }

    // Getter pour l'ID de l'article
    public function getId(): ?int
    {
        return $this->id;
    }

    // Getter pour le titre de l'article
    public function getTitle(): ?string
    {
        return $this->title;
    }

    // Setter pour le titre de l'article
    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    // Getter pour le contenu de l'article
    public function getContent(): ?string
    {
        return $this->content;
    }

    // Setter pour le contenu de l'article
    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    // Getter pour la date de publication de l'article
    public function getPublicationDate(): ?\DateTimeImmutable
    {
        return $this->publication_date;
    }

    // Setter pour la date de publication de l'article
    public function setPublicationDate(\DateTimeImmutable $publication_date): static
    {
        $this->publication_date = $publication_date;

        return $this;
    }

    /**
     * @return Collection<int, Comment> // Retourne la collection des commentaires associés à cet article
     */
    // Getter pour obtenir la collection des commentaires de l'article
    public function getComment(): Collection
    {
        return $this->comment;
    }

    // Méthode pour ajouter un commentaire à la collection de commentaires
    public function addComment(Comment $comment): static
    {
        // Vérifie si le commentaire n'est pas déjà dans la collection
        if (!$this->comment->contains($comment)) {
            $this->comment->add($comment); // Ajoute le commentaire à la collection
            $comment->setArticles($this); // Associe ce commentaire à l'article
        }

        return $this;
    }

    // Méthode pour retirer un commentaire de la collection de commentaires
    public function removeComment(Comment $comment): static
    {
        // Retire le commentaire de la collection
        if ($this->comment->removeElement($comment)) {
            // Si le commentaire est supprimé, on met à null la relation inverse dans l'entité Comment
            if ($comment->getArticles() === $this) {
                $comment->setArticles(null); // Détache le commentaire de l'article
            }
        }

        return $this;
    }
}
