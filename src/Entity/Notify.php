<?php

namespace App\Entity;

use App\Repository\NotifyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotifyRepository::class)]
class Notify
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $delay = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $message = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $sending_date = null;

    #[ORM\ManyToOne(inversedBy: 'notify')]
    private ?Users $user = null;

    /**
     * @var Collection<int, LunarPhase>
     */
    #[ORM\OneToMany(targetEntity: LunarPhase::class, mappedBy: 'notify')]
    private Collection $lunarPhases;

    public function __construct()
    {
        $this->lunarPhases = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDelay(): ?int
    {
        return $this->delay;
    }

    public function setDelay(int $delay): static
    {
        $this->delay = $delay;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): static
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

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, LunarPhase>
     */
    public function getLunarPhases(): Collection
    {
        return $this->lunarPhases;
    }

    public function addLunarPhase(LunarPhase $lunarPhase): static
    {
        if (!$this->lunarPhases->contains($lunarPhase)) {
            $this->lunarPhases->add($lunarPhase);
            $lunarPhase->setNotify($this);
        }

        return $this;
    }

    public function removeLunarPhase(LunarPhase $lunarPhase): static
    {
        if ($this->lunarPhases->removeElement($lunarPhase)) {
            // set the owning side to null (unless already changed)
            if ($lunarPhase->getNotify() === $this) {
                $lunarPhase->setNotify(null);
            }
        }

        return $this;
    }
}
