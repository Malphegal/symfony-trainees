<?php

namespace App\Entity;

use App\Repository\SubscribeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SubscribeRepository::class)
 */
class Subscribe
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Trainee::class, inversedBy="subscribes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $trainee;

    /**
     * @ORM\ManyToOne(targetEntity=Session::class, inversedBy="subscribes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $session;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTrainee(): ?Trainee
    {
        return $this->trainee;
    }

    public function setTrainee(?Trainee $trainee): self
    {
        $this->trainee = $trainee;

        return $this;
    }

    public function getSession(): ?Session
    {
        return $this->session;
    }

    public function setSession(?Session $session): self
    {
        $this->session = $session;

        return $this;
    }
    
    public function getSessionWithDate(): string
    {
        return $this->session->getId()
            . "__"
            . $this->session->getName()
            . " - Du " . $this->session->getStarts()->format("d/m/Y")
            . " au " . $this->session->getEnds();
    }
}
