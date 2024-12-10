<?php

namespace App\Entity;

use App\Repository\LunarPhaseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LunarPhaseRepository::class)]
class LunarPhase
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $phase_name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $start_date = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $end_date = null;

    /**
     * @var Collection<int, Ritual>
     */
    #[ORM\ManyToMany(targetEntity: Ritual::class)]
    private Collection $Associate;

    #[ORM\ManyToOne(inversedBy: 'lunarPhases')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Notify $notify = null;

    #[ORM\Column(length: 50)]
    private ?string $moon_sign = null;

    public function __construct()
    {
        $this->Associate = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhaseName(): ?string
    {
        return $this->phase_name;
    }

    public function setPhaseName(string $phase_name): static
    {
        $this->phase_name = $phase_name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStartDate(): ?\DateTimeImmutable
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeImmutable $start_date): static
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeImmutable
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeImmutable $end_date): static
    {
        $this->end_date = $end_date;

        return $this;
    }

    /**
     * @return Collection<int, Ritual>
     */
    public function getAssociate(): Collection
    {
        return $this->Associate;
    }

    public function addAssociate(Ritual $associate): static
    {
        if (!$this->Associate->contains($associate)) {
            $this->Associate->add($associate);
        }

        return $this;
    }

    public function removeAssociate(Ritual $associate): static
    {
        $this->Associate->removeElement($associate);

        return $this;
    }

    public function getNotify(): ?Notify
    {
        return $this->notify;
    }

    public function setNotify(?Notify $notify): static
    {
        $this->notify = $notify;

        return $this;
    }

    public function getMoonSign(): ?string
    {
        return $this->moon_sign;
    }

    public function setMoonSign(string $moon_sign): static
    {
        $this->moon_sign = $moon_sign;

        return $this;
    }
}
