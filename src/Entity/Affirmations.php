<?php

namespace App\Entity;

use App\Repository\AffirmationsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AffirmationsRepository::class)]
class Affirmations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $highlighted_since = null;

    #[ORM\Column]
    private ?bool $is_highlighted = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getHighlightedSince(): ?\DateTimeImmutable
    {
        return $this->highlighted_since;
    }

    public function setHighlightedSince(?\DateTimeImmutable $highlighted_since): static
    {
        $this->highlighted_since = $highlighted_since;

        return $this;
    }

    public function isHighlighted(): ?bool
    {
        return $this->is_highlighted;
    }

    public function setHighlighted(bool $is_highlighted): static
    {
        $this->is_highlighted = $is_highlighted;

        return $this;
    }
}
