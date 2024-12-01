<?php

namespace App\Entity;

use App\Repository\MoonNotificationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MoonNotificationRepository::class)]
class MoonNotification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $full_moon_notify = null;

    #[ORM\Column]
    private ?bool $new_moon_notify = null;

    #[ORM\Column]
    private ?bool $solar_eclipse_notify = null;

    #[ORM\Column]
    private ?bool $moon_eclipse_notify = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isFullMoonNotify(): ?bool
    {
        return $this->full_moon_notify;
    }

    public function setFullMoonNotify(bool $full_moon_notify): static
    {
        $this->full_moon_notify = $full_moon_notify;

        return $this;
    }

    public function isNewMoonNotify(): ?bool
    {
        return $this->new_moon_notify;
    }

    public function setNewMoonNotify(bool $new_moon_notify): static
    {
        $this->new_moon_notify = $new_moon_notify;

        return $this;
    }

    public function isSolarEclipseNotify(): ?bool
    {
        return $this->solar_eclipse_notify;
    }

    public function setSolarEclipseNotify(bool $solar_eclipse_notify): static
    {
        $this->solar_eclipse_notify = $solar_eclipse_notify;

        return $this;
    }

    public function isMoonEclipseNotify(): ?bool
    {
        return $this->moon_eclipse_notify;
    }

    public function setMoonEclipseNotify(bool $moon_eclipse_notify): static
    {
        $this->moon_eclipse_notify = $moon_eclipse_notify;

        return $this;
    }
}
