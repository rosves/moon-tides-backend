<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)] // Déclare cette classe comme une entité et spécifie le repository associé
class Comment
{
    #[ORM\Id] // Spécifie que ce champ est la clé primaire de l'entité
    #[ORM\GeneratedValue] // Spécifie que la valeur de l'ID est générée automatiquement
    #[ORM\Column] // Déclare une colonne dans la base de données
    private ?int $id = null; // Propriété ID de l'entité Comment

    #[ORM\Column] // Déclare une colonne de type date pour la date du commentaire
    private ?\DateTimeImmutable $comment_date = null; // Propriété de la date du commentaire

    #[ORM\Column(length: 255)] // Déclare une colonne de type string pour le texte du commentaire avec une longueur maximale de 255 caractères
    private ?string $comment = null; // Propriété du texte du commentaire

    #[ORM\ManyToOne(inversedBy: 'comment')] // Relation ManyToOne avec l'entité Users
    #[ORM\JoinColumn(nullable: true)] // Spécifie que la colonne peut être nulle
    private ?Users $users = null; // Propriété qui lie le commentaire à un utilisateur (facultatif)

    #[ORM\ManyToOne(inversedBy: 'comment')] // Relation ManyToOne avec l'entité Articles
    private ?Articles $articles = null; // Propriété qui lie le commentaire à un article

    // Getter pour l'ID du commentaire
    public function getId(): ?int
    {
        return $this->id;
    }

    // Getter pour la date du commentaire
    public function getCommentDate(): ?\DateTimeImmutable
    {
        return $this->comment_date;
    }

    // Setter pour la date du commentaire
    public function setCommentDate(\DateTimeImmutable $comment_date): static
    {
        $this->comment_date = $comment_date;

        return $this;
    }

    // Getter pour le contenu du commentaire
    public function getComment(): ?string
    {
        return $this->comment;
    }

    // Setter pour le contenu du commentaire
    public function setComment(string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    // Getter pour l'utilisateur associé au commentaire
    public function getUsers(): ?Users
    {
        return $this->users;
    }

    // Setter pour l'utilisateur associé au commentaire
    public function setUsers(?Users $users): static
    {
        $this->users = $users;

        return $this;
    }

    // Getter pour l'article associé au commentaire
    public function getArticles(): ?Articles
    {
        return $this->articles;
    }

    // Setter pour l'article associé au commentaire
    public function setArticles(?Articles $articles): static
    {
        $this->articles = $articles;

        return $this;
    }
}
