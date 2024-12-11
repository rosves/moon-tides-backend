<?php

namespace App\Entity;

use App\Repository\RitualRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RitualRepository::class)] // Déclare la classe comme une entité Doctrine, associée au repository RitualRepository
class Ritual
{
    #[ORM\Id] // Cette annotation définit la propriété id comme la clé primaire de l'entité
    #[ORM\GeneratedValue] // Indique que la valeur de l'ID sera générée automatiquement
    #[ORM\Column] // Mappe la propriété sur une colonne dans la base de données
    private ?int $id = null; // Identifiant du rituel

    #[ORM\Column(length: 100)] // Définit une colonne pour le nom du rituel avec une longueur maximale de 100 caractères
    private ?string $ritual_name = null; // Nom du rituel

    #[ORM\Column(type: Types::TEXT, nullable: true)] // Colonne de type texte, permet d'ajouter une description longue pour le rituel (nullable signifie que ce champ peut être vide)
    private ?string $description = null; // Description du rituel

    #[ORM\Column(length: 100, nullable: true)] // Colonne pour un lien URL associé au rituel, aussi nullable (peut être vide)
    private ?string $link = null; // Lien vers des ressources supplémentaires pour le rituel (facultatif)

    // Getter pour l'ID du rituel
    public function getId(): ?int
    {
        return $this->id;
    }

    // Getter pour le nom du rituel
    public function getRitualName(): ?string
    {
        return $this->ritual_name;
    }

    // Setter pour le nom du rituel
    public function setRitualName(string $ritual_name): static
    {
        $this->ritual_name = $ritual_name;

        return $this;
    }

    // Getter pour la description du rituel
    public function getDescription(): ?string
    {
        return $this->description;
    }

    // Setter pour la description du rituel
    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    // Getter pour le lien associé au rituel
    public function getLink(): ?string
    {
        return $this->link;
    }

    // Setter pour le lien associé au rituel
    public function setLink(?string $link): static
    {
        $this->link = $link;

        return $this;
    }
}
