<?php

namespace App\Entity;

use App\Repository\JournalRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JournalRepository::class)]
class Journal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $add_date = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $note_entry = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $belongs = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddDate(): ?\DateTimeImmutable
    {
        return $this->add_date;
    }

    public function setAddDate(\DateTimeImmutable $add_date): static
    {
        $this->add_date = $add_date;

        return $this;
    }

    public function getNoteEntry(): ?string
    {
        return $this->note_entry;
    }

    public function setNoteEntry(string $note_entry): static
    {
        $this->note_entry = $note_entry;

        return $this;
    }

    public function getBelongs(): ?Users
    {
        return $this->belongs;
    }

    public function setBelongs(?Users $belongs): static
    {
        $this->belongs = $belongs;

        return $this;
    }
}
