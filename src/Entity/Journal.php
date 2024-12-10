<?php

namespace App\Entity;

use App\Repository\JournalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JournalRepository::class)]

class Journal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, NoteEntries>
     */
    #[ORM\OneToMany(targetEntity: NoteEntries::class, mappedBy: 'CreateNote')]
    private Collection $CreateNote;

    public function __construct()
    {
        $this->CreateNote = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, NoteEntries>
     */
    public function getCreateNote(): Collection
    {
        return $this->CreateNote;
    }

    public function addCreateNote(NoteEntries $createNote): static
    {
        if (!$this->CreateNote->contains($createNote)) {
            $this->CreateNote->add($createNote);
            $createNote->setCreateNote($this);
        }

        return $this;
    }

    public function removeCreateNote(NoteEntries $createNote): static
    {
        if ($this->CreateNote->removeElement($createNote)) {
            // set the owning side to null (unless already changed)
            if ($createNote->getCreateNote() === $this) {
                $createNote->setCreateNote(null);
            }
        }

        return $this;
    }

  


}
