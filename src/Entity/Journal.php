<?php

namespace App\Entity;

use App\Repository\JournalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JournalRepository::class)] // Déclare cette classe comme une entité et spécifie le repository associé
class Journal
{
    #[ORM\Id] // Spécifie que ce champ est la clé primaire de l'entité
    #[ORM\GeneratedValue] // Spécifie que la valeur de l'ID est générée automatiquement
    #[ORM\Column] // Déclare une colonne dans la base de données
    private ?int $id = null; // Propriété ID de l'entité Journal

    /**
     * @var Collection<int, NoteEntries> // Déclare une collection d'entrées de notes (NoteEntries)
     */
    #[ORM\OneToMany(targetEntity: NoteEntries::class, mappedBy: 'CreateNote')] // Spécifie une relation OneToMany avec l'entité NoteEntries
    private Collection $CreateNote; // Propriété contenant toutes les entrées de notes associées à ce journal

    // Constructeur de la classe, initialise la collection d'entrées de notes
    public function __construct()
    {
        $this->CreateNote = new ArrayCollection(); // Initialise la collection pour stocker les entrées de notes
    }

    // Getter pour l'ID du journal
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, NoteEntries> // Retourne la collection des entrées de notes
     */
    // Getter pour obtenir la collection des entrées de notes
    public function getCreateNote(): Collection
    {
        return $this->CreateNote;
    }

    // Méthode pour ajouter une entrée de note à la collection
    public function addCreateNote(NoteEntries $createNote): static
    {
        // Vérifie si l'entrée de note n'est pas déjà dans la collection
        if (!$this->CreateNote->contains($createNote)) {
            $this->CreateNote->add($createNote); // Ajoute l'entrée de note à la collection
            $createNote->setCreateNote($this); // Associe cette entrée de note au journal
        }

        return $this;
    }

    // Méthode pour retirer une entrée de note de la collection
    public function removeCreateNote(NoteEntries $createNote): static
    {
        // Retire l'entrée de note de la collection
        if ($this->CreateNote->removeElement($createNote)) {
            // Si l'entrée de note est supprimée, on met à null la relation inverse dans l'entité NoteEntries
            if ($createNote->getCreateNote() === $this) {
                $createNote->setCreateNote(null); // Détache l'entrée de note du journal
            }
        }

        return $this;
    }
}
