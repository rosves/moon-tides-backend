<?php

namespace App\Entity;

use App\Repository\RolesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RolesRepository::class)]
class Roles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private ?string $label_role = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabelRole(): ?string
    {
        return $this->label_role;
    }

    public function setLabelRole(string $label_role): static
    {
        $this->label_role = $label_role;

        return $this;
    }
}
