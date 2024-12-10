<?php

namespace App\Entity;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\NoteEntriesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NoteEntriesRepository::class)]
#[ORM\HasLifecycleCallbacks]
class NoteEntries
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('user:noteentries')]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups('user:noteentries')]
    private ?string $noteContent = null;

    #[ORM\Column(length: 100)]
    #[Groups('user:noteentries')]
    private ?string $noteTitle = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Groups('user:noteentries')]
    private ?\DateTimeImmutable $noteDate = null;

    #[ORM\ManyToOne(inversedBy: 'CreateNote')]
    private ?Journal $CreateNote = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNoteContent(): ?string
    {
        return $this->noteContent;
    }

    public function setNoteContent(string $noteContent): static
    {
        $this->noteContent = $noteContent;

        return $this;
    }

    public function getNoteTitle(): ?string
    {
        return $this->noteTitle;
    }

    public function setNoteTitle(string $noteTitle): static
    {
        $this->noteTitle = $noteTitle;

        return $this;
    }

    public function getNoteDate(): ?\DateTimeImmutable
    {
        return $this->noteDate;
    }
    #[ORM\PrePersist]
    public function setNoteDate(): static
    {
        $this->noteDate = new \DateTimeImmutable();
        return $this;
    }

    public function getCreateNote(): ?Journal
    {
        return $this->CreateNote;
    }

    public function setCreateNote(?Journal $CreateNote): static
    {
        $this->CreateNote = $CreateNote;

        return $this;
    }
}
