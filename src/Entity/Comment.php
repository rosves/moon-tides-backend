<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $comment_date = null;

    #[ORM\Column(length: 255)]
    private ?string $comment = null;

    #[ORM\ManyToOne(inversedBy: 'comment')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Users $users = null;

    #[ORM\ManyToOne(inversedBy: 'comment')]
    private ?Articles $articles = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentDate(): ?\DateTimeImmutable
    {
        return $this->comment_date;
    }

    public function setCommentDate(\DateTimeImmutable $comment_date): static
    {
        $this->comment_date = $comment_date;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(?Users $users): static
    {
        $this->users = $users;

        return $this;
    }

    public function getArticles(): ?Articles
    {
        return $this->articles;
    }

    public function setArticles(?Articles $articles): static
    {
        $this->articles = $articles;

        return $this;
    }
}
