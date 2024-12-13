<?php

namespace App\Entity;

use App\Repository\LunarPhaseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LunarPhaseRepository::class)] // Déclare cette classe comme une entité et spécifie le repository associé
class LunarPhase
{
    #[ORM\Id] // Déclare la propriété comme étant la clé primaire
    #[ORM\GeneratedValue] // La valeur de l'ID est générée automatiquement
    #[ORM\Column] // Déclare une colonne pour l'ID dans la base de données
    #[Groups('user:lunarphase')]
    private ?int $id = null; // Propriété pour l'ID de la phase lunaire

    #[ORM\Column(length: 100)] // Déclare une colonne de type string pour le nom de la phase lunaire, avec une longueur maximale de 100 caractères
    #[Groups('user:lunarphase')]
    private ?string $phase_name = null; // Propriété pour le nom de la phase lunaire


    #[ORM\Column(type: Types::TEXT)] // Déclare une colonne de type texte pour la description de la phase lunaire
    #[Groups('user:lunarphase')]
    private ?string $description = null; // Propriété pour la description de la phase lunaire



    #[ORM\ManyToOne(inversedBy: 'lunarPhases')] // Relation ManyToOne avec l'entité Notify (une phase lunaire peut être associée à une notification)
    #[ORM\JoinColumn(nullable: true)] // La relation ne peut pas être nulle
    #[Groups('user:lunarphase')]
    private ?Notify $notify = null; // Propriété pour la notification associée à la phase lunaire


    // Getter pour l'ID de la phase lunaire
    public function getId(): ?int
    {
        return $this->id;
    }

    // Getter pour le nom de la phase lunaire
    public function getPhaseName(): ?string
    {
        return $this->phase_name;
    }

    // Setter pour le nom de la phase lunaire
    public function setPhaseName(string $phase_name): static
    {
        $this->phase_name = $phase_name;

        return $this;
    }

    // Getter pour la description de la phase lunaire
    public function getDescription(): ?string
    {
        return $this->description;
    }

    // Setter pour la description de la phase lunaire
    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }


    // Getter pour la notification associée à la phase lunaire
    public function getNotify(): ?Notify
    {
        return $this->notify;
    }

    // Setter pour la notification associée à la phase lunaire
    public function setNotify(?Notify $notify): static
    {
        $this->notify = $notify;

        return $this;
    }
}
