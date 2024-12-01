<?php

namespace App\Entity;

use App\Repository\NotificationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotificationRepository::class)]
class Notification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $message = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $sending_date = null;

    #[ORM\Column(length: 50)]
    private ?string $type_notification = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getSendingDate(): ?\DateTimeImmutable
    {
        return $this->sending_date;
    }

    public function setSendingDate(\DateTimeImmutable $sending_date): static
    {
        $this->sending_date = $sending_date;

        return $this;
    }

    public function getTypeNotification(): ?string
    {
        return $this->type_notification;
    }

    public function setTypeNotification(string $type_notification): static
    {
        $this->type_notification = $type_notification;

        return $this;
    }
}
