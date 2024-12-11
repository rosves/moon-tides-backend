<?php

namespace App\Entity;

use App\Repository\NotifyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotifyRepository::class)] // Déclare la classe comme une entité, en spécifiant le repository associé
class Notify
{
    #[ORM\Id] // Définit cette propriété comme la clé primaire de l'entité
    #[ORM\GeneratedValue] // L'ID sera généré automatiquement
    #[ORM\Column] // Cette propriété est mappée sur une colonne dans la base de données
    private ?int $id = null; // Identifiant de la notification

    #[ORM\Column] // Définit une colonne pour le délai (par exemple, combien de temps avant d'envoyer la notification)
    private ?int $delay = null; // Délai en minutes ou autres unités pour l'envoi de la notification

    #[ORM\Column(length: 255, nullable: true)] // Définit une colonne pour le message de la notification, avec une longueur maximale de 255 caractères
    private ?string $message = null; // Message de la notification

    #[ORM\Column] // Colonne pour la date et l'heure d'envoi de la notification
    private ?\DateTimeImmutable $sending_date = null; // Date d'envoi de la notification

    #[ORM\ManyToOne(inversedBy: 'notify')] // Relation ManyToOne, un utilisateur peut avoir plusieurs notifications
    private ?Users $user = null; // L'utilisateur auquel cette notification est associée

    /**
     * @var Collection<int, LunarPhase> // Spécifie que cette propriété contient une collection de LunarPhase
     */
    #[ORM\OneToMany(targetEntity: LunarPhase::class, mappedBy: 'notify')] // Relation OneToMany, une notification peut être associée à plusieurs phases lunaires
    private Collection $lunarPhases; // Collection des phases lunaires associées à cette notification

    // Constructeur de la classe, initialisant la collection de phases lunaires
    public function __construct()
    {
        $this->lunarPhases = new ArrayCollection(); // Initialise la collection de phases lunaires comme une nouvelle ArrayCollection
    }

    // Getter pour l'ID de la notification
    public function getId(): ?int
    {
        return $this->id;
    }

    // Getter pour obtenir le délai de la notification
    public function getDelay(): ?int
    {
        return $this->delay;
    }

    // Setter pour définir le délai de la notification
    public function setDelay(int $delay): static
    {
        $this->delay = $delay;

        return $this;
    }

    // Getter pour obtenir le message de la notification
    public function getMessage(): ?string
    {
        return $this->message;
    }

    // Setter pour définir le message de la notification
    public function setMessage(?string $message): static
    {
        $this->message = $message;

        return $this;
    }

    // Getter pour obtenir la date d'envoi de la notification
    public function getSendingDate(): ?\DateTimeImmutable
    {
        return $this->sending_date;
    }

    // Setter pour définir la date d'envoi de la notification
    public function setSendingDate(\DateTimeImmutable $sending_date): static
    {
        $this->sending_date = $sending_date;

        return $this;
    }

    // Getter pour obtenir l'utilisateur associé à la notification
    public function getUser(): ?Users
    {
        return $this->user;
    }

    // Setter pour associer un utilisateur à la notification
    public function setUser(?Users $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, LunarPhase> // Retourne la collection des phases lunaires associées à cette notification
     */
    public function getLunarPhases(): Collection
    {
        return $this->lunarPhases;
    }

    // Méthode pour ajouter une phase lunaire à la notification
    public function addLunarPhase(LunarPhase $lunarPhase): static
    {
        if (!$this->lunarPhases->contains($lunarPhase)) { // Vérifie si la phase lunaire n'est pas déjà dans la collection
            $this->lunarPhases->add($lunarPhase); // Ajoute la phase lunaire à la collection
            $lunarPhase->setNotify($this); // Associe cette notification à la phase lunaire
        }

        return $this;
    }

    // Méthode pour supprimer une phase lunaire de la notification
    public function removeLunarPhase(LunarPhase $lunarPhase): static
    {
        if ($this->lunarPhases->removeElement($lunarPhase)) { // Supprime la phase lunaire de la collection
            // Si la phase lunaire appartient encore à cette notification, dissocie la notification de la phase lunaire
            if ($lunarPhase->getNotify() === $this) {
                $lunarPhase->setNotify(null); // Dissocie la notification de la phase lunaire
            }
        }

        return $this;
    }
}
