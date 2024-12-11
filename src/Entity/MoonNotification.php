<?php

namespace App\Entity;

use App\Repository\MoonNotificationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MoonNotificationRepository::class)] // Déclare la classe comme une entité et spécifie le repository associé
#[ORM\HasLifecycleCallbacks] // Active les callbacks du cycle de vie, permettant d'intervenir à certains moments de la vie de l'entité (par exemple, avant la persistance)
class MoonNotification
{
    #[ORM\Id] // Indique que cette propriété est la clé primaire de l'entité
    #[ORM\GeneratedValue] // La valeur de l'ID est générée automatiquement
    #[ORM\Column] // Cette propriété est mappée sur une colonne de la base de données
    private ?int $id = null; // Identifiant unique de la notification

    #[ORM\Column] // Déclare une colonne pour indiquer si la notification de la pleine lune est activée
    private ?bool $full_moon_notify = null; // Propriété pour la notification de la pleine lune

    #[ORM\Column] // Déclare une colonne pour indiquer si la notification de la nouvelle lune est activée
    private ?bool $new_moon_notify = null; // Propriété pour la notification de la nouvelle lune

    #[ORM\Column] // Déclare une colonne pour indiquer si la notification de l'éclipse solaire est activée
    private ?bool $solar_eclipse_notify = null; // Propriété pour la notification de l'éclipse solaire

    #[ORM\Column] // Déclare une colonne pour indiquer si la notification de l'éclipse lunaire est activée
    private ?bool $moon_eclipse_notify = null; // Propriété pour la notification de l'éclipse lunaire

    // Callback exécuté avant la persistance de l'entité pour définir les valeurs par défaut
    #[ORM\PrePersist] 
    public function setDefaultValue()
    {
        $this->full_moon_notify = false; // Définit la notification de la pleine lune à false par défaut
        $this->new_moon_notify = false;  // Définit la notification de la nouvelle lune à false par défaut
        $this->solar_eclipse_notify = false; // Définit la notification de l'éclipse solaire à false par défaut
        $this->moon_eclipse_notify = false; // Définit la notification de l'éclipse lunaire à false par défaut
    }

    // Getter pour l'ID de la notification
    public function getId(): ?int
    {
        return $this->id;
    }

    // Getter pour vérifier si la notification de la pleine lune est activée
    public function isFullMoonNotify(): ?bool
    {
        return $this->full_moon_notify;
    }

    // Setter pour activer/désactiver la notification de la pleine lune
    public function setFullMoonNotify(bool $full_moon_notify): static
    {
        $this->full_moon_notify = $full_moon_notify;

        return $this;
    }

    // Getter pour vérifier si la notification de la nouvelle lune est activée
    public function isNewMoonNotify(): ?bool
    {
        return $this->new_moon_notify;
    }

    // Setter pour activer/désactiver la notification de la nouvelle lune
    public function setNewMoonNotify(bool $new_moon_notify): static
    {
        $this->new_moon_notify = $new_moon_notify;

        return $this;
    }

    // Getter pour vérifier si la notification de l'éclipse solaire est activée
    public function isSolarEclipseNotify(): ?bool
    {
        return $this->solar_eclipse_notify;
    }

    // Setter pour activer/désactiver la notification de l'éclipse solaire
    public function setSolarEclipseNotify(bool $solar_eclipse_notify): static
    {
        $this->solar_eclipse_notify = $solar_eclipse_notify;

        return $this;
    }

    // Getter pour vérifier si la notification de l'éclipse lunaire est activée
    public function isMoonEclipseNotify(): ?bool
    {
        return $this->moon_eclipse_notify;
    }

    // Setter pour activer/désactiver la notification de l'éclipse lunaire
    public function setMoonEclipseNotify(bool $moon_eclipse_notify): static
    {
        $this->moon_eclipse_notify = $moon_eclipse_notify;

        return $this;
    }
}
