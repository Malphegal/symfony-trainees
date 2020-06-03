<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SessionRepository::class)
 */
class Session
{
    const format = "d M Y";

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $seat;

    /**
     * @ORM\Column(type="datetime")
     */
    private $starts;

    /**
     * @ORM\OneToMany(targetEntity=Contain::class, mappedBy="session", orphanRemoval=true)
     */
    private $contains;

    /**
     * @ORM\OneToMany(targetEntity=Subscribe::class, mappedBy="session", orphanRemoval=true)
     */
    private $subscribes;

    /**
     * @ORM\Column(type="string", length=70)
     */
    private $name;

    public function __construct()
    {
        $this->contains = new ArrayCollection();
        $this->subscribes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSeat(): ?int
    {
        return $this->seat;
    }

    public function setSeat(int $seat): self
    {
        $this->seat = $seat;

        return $this;
    }

    public function getStarts(): ?\DateTimeInterface
    {
        return $this->starts;
    }

    public function setStarts(\DateTimeInterface $starts): self
    {
        $this->starts = $starts;

        return $this;
    }

    /**
     * @return Collection|Contain[]
     */
    public function getContains(): Collection
    {
        return $this->contains;
    }

    public function addContain(Contain $contain): self
    {
        if (!$this->contains->contains($contain)) {
            $this->contains[] = $contain;
            $contain->setSession($this);
        }

        return $this;
    }

    public function removeContain(Contain $contain): self
    {
        if ($this->contains->contains($contain)) {
            $this->contains->removeElement($contain);
            // set the owning side to null (unless already changed)
            if ($contain->getSession() === $this) {
                $contain->setSession(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Subscribe[]
     */
    public function getSubscribes(): Collection
    {
        return $this->subscribes;
    }

    public function addSubscribe(Subscribe $subscribe): self
    {
        if (!$this->subscribes->contains($subscribe)) {
            $this->subscribes[] = $subscribe;
            $subscribe->setSession($this);
        }

        return $this;
    }

    public function removeSubscribe(Subscribe $subscribe): self
    {
        if ($this->subscribes->contains($subscribe)) {
            $this->subscribes->removeElement($subscribe);
            // set the owning side to null (unless already changed)
            if ($subscribe->getSession() === $this) {
                $subscribe->setSession(null);
            }
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getOrderedItems(): array
    {
        $res = [];
        foreach ($this->contains as $c)
        {
            if (!array_key_exists($c->getItem()->getCategory()->getName(), $res))
                $res[$c->getItem()->getCategory()->getName()] = [];
            $res[$c->getItem()->getCategory()->getName()][] = ["item" => $c->getItem()->getName(), "duration" => $c->getDuration()];
        }
        return $res;
    }

    public function getFormattedStarts(): string
    {
        return $this->starts->format(self::format);
    }

    public function getEnds(): string
    {
        $count = 0;

        foreach ($this->contains as $sub)
            $count += $sub->getDuration();

        return $this->starts->modify('+ ' . $count . ' day')->format(self::format);
    }
}
