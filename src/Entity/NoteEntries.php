<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\NoteEntriesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NoteEntriesRepository::class)] // Spécifie que cette classe est une entité et son repository
#[ORM\HasLifecycleCallbacks] // Active les callbacks de cycle de vie (exécution de méthodes avant ou après certaines opérations)
class NoteEntries
{
    #[ORM\Id] // Indique que ce champ est la clé primaire
    #[ORM\GeneratedValue] // Indique que la valeur de l'ID est générée automatiquement
    #[ORM\Column] // Déclare une colonne dans la base de données
    #[Groups('user:noteentries')] // Cette annotation permet de spécifier les groupes de sérialisation pour l'exportation des données
    private ?int $id = null; // Propriété de l'ID de l'entrée de note, de type entier

    #[ORM\Column(type: Types::TEXT)] // Déclare une colonne de type TEXT dans la base de données
    #[Groups('user:noteentries')] // Spécifie un groupe de sérialisation pour le contenu de la note
    private ?string $noteContent = null; // Contenu de la note

    #[ORM\Column(length: 100)] // Déclare une colonne de type chaîne de caractères avec une longueur maximale de 100
    #[Groups('user:noteentries')] // Spécifie un groupe de sérialisation pour le titre de la note
    private ?string $noteTitle = null; // Titre de la note

    #[ORM\Column(type: Types::DATE_IMMUTABLE)] // Déclare une colonne de type date immuable dans la base de données
    #[Groups('user:noteentries')] // Spécifie un groupe de sérialisation pour la date de la note
    private ?\DateTimeImmutable $noteDate = null; // Date de création de la note

    #[ORM\ManyToOne(inversedBy: 'CreateNote')] // Spécifie une relation ManyToOne avec l'entité Journal
    private ?Journal $CreateNote = null; // Journal associé à l'entrée de la note

    // Getter pour l'ID de la note
    public function getId(): ?int
    {
        return $this->id;
    }

    // Getter pour le contenu de la note
    public function getNoteContent(): ?string
    {
        return $this->noteContent;
    }

    // Setter pour le contenu de la note
    public function setNoteContent(string $noteContent): static
    {
        $this->noteContent = $noteContent;

        return $this;
    }

    // Getter pour le titre de la note
    public function getNoteTitle(): ?string
    {
        return $this->noteTitle;
    }

    // Setter pour le titre de la note
    public function setNoteTitle(string $noteTitle): static
    {
        $this->noteTitle = $noteTitle;

        return $this;
    }

    // Getter pour la date de la note
    public function getNoteDate(): ?\DateTimeImmutable
    {
        return $this->noteDate;
    }

    // Méthode de callback qui est exécutée avant la persistance de l'entité dans la base de données
    #[ORM\PrePersist]
    public function setNoteDate(): static
    {
        // Définit la date de création de la note à la date actuelle lors de la création de l'entité
        $this->noteDate = new \DateTimeImmutable();
        return $this;
    }

    // Getter pour le journal associé à l'entrée de note
    public function getCreateNote(): ?Journal
    {
        return $this->CreateNote;
    }

    // Setter pour le journal associé à l'entrée de note
    public function setCreateNote(?Journal $CreateNote): static
    {
        $this->CreateNote = $CreateNote;

        return $this;
    }
}
