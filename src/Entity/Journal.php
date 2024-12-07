<?php

namespace App\Entity;

use App\Repository\JournalRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JournalRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Journal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $add_date = null;


    #[ORM\Column(type: Types::TEXT , nullable:true)]
    private ?string $note_entry = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddDate(): ?\DateTimeImmutable
    {
        return $this->add_date;
    }

    #[ORM\PrePersist]
    public function setAddDate()
    {
        $this->add_date = new \DateTimeImmutable();

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
}
