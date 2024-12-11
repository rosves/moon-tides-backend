<?php

namespace App\Entity;

use App\Repository\LunarPhaseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LunarPhaseRepository::class)] // Déclare cette classe comme une entité et spécifie le repository associé
class LunarPhase
{
    #[ORM\Id] // Déclare la propriété comme étant la clé primaire
    #[ORM\GeneratedValue] // La valeur de l'ID est générée automatiquement
    #[ORM\Column] // Déclare une colonne pour l'ID dans la base de données
    private ?int $id = null; // Propriété pour l'ID de la phase lunaire

    #[ORM\Column(length: 100)] // Déclare une colonne de type string pour le nom de la phase lunaire, avec une longueur maximale de 100 caractères
    private ?string $phase_name = null; // Propriété pour le nom de la phase lunaire

    #[ORM\Column(type: Types::TEXT)] // Déclare une colonne de type texte pour la description de la phase lunaire
    private ?string $description = null; // Propriété pour la description de la phase lunaire

    #[ORM\Column] // Déclare une colonne de type date pour la date de début de la phase lunaire
    private ?\DateTimeImmutable $start_date = null; // Propriété pour la date de début de la phase lunaire

    #[ORM\Column] // Déclare une colonne de type date pour la date de fin de la phase lunaire
    private ?\DateTimeImmutable $end_date = null; // Propriété pour la date de fin de la phase lunaire

    /**
     * @var Collection<int, Ritual>
     */
    #[ORM\ManyToMany(targetEntity: Ritual::class)] // Déclare une relation ManyToMany avec l'entité Ritual (un rituel peut être associé à plusieurs phases lunaires)
    private Collection $Associate; // Propriété pour stocker les rituels associés à la phase lunaire

    #[ORM\ManyToOne(inversedBy: 'lunarPhases')] // Relation ManyToOne avec l'entité Notify (une phase lunaire peut être associée à une notification)
    #[ORM\JoinColumn(nullable: false)] // La relation ne peut pas être nulle
    private ?Notify $notify = null; // Propriété pour la notification associée à la phase lunaire

    #[ORM\Column(length: 50)] // Déclare une colonne de type string pour le signe lunaire, avec une longueur maximale de 50 caractères
    private ?string $moon_sign = null; // Propriété pour le signe lunaire de la phase

    // Constructeur qui initialise la collection des rituels associés
    public function __construct()
    {
        $this->Associate = new ArrayCollection(); // Initialise la collection des rituels associés
    }

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

    // Getter pour la date de début de la phase lunaire
    public function getStartDate(): ?\DateTimeImmutable
    {
        return $this->start_date;
    }

    // Setter pour la date de début de la phase lunaire
    public function setStartDate(\DateTimeImmutable $start_date): static
    {
        $this->start_date = $start_date;

        return $this;
    }

    // Getter pour la date de fin de la phase lunaire
    public function getEndDate(): ?\DateTimeImmutable
    {
        return $this->end_date;
    }

    // Setter pour la date de fin de la phase lunaire
    public function setEndDate(\DateTimeImmutable $end_date): static
    {
        $this->end_date = $end_date;

        return $this;
    }

    /**
     * Getter pour la collection des rituels associés à la phase lunaire
     * @return Collection<int, Ritual>
     */
    public function getAssociate(): Collection
    {
        return $this->Associate;
    }

    // Ajouter un rituel à la collection des rituels associés
    public function addAssociate(Ritual $associate): static
    {
        if (!$this->Associate->contains($associate)) {
            $this->Associate->add($associate); // Ajoute le rituel à la collection
        }

        return $this;
    }

    // Supprimer un rituel de la collection des rituels associés
    public function removeAssociate(Ritual $associate): static
    {
        $this->Associate->removeElement($associate); // Supprime le rituel de la collection

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

    // Getter pour le signe lunaire de la phase
    public function getMoonSign(): ?string
    {
        return $this->moon_sign;
    }

    // Setter pour le signe lunaire de la phase
    public function setMoonSign(string $moon_sign): static
    {
        $this->moon_sign = $moon_sign;

        return $this;
    }
}
