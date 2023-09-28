<?php

namespace App\Entity;

use App\Repository\FeesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FeesRepository::class)]
class Fees
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $price;

    #[ORM\ManyToOne(targetEntity: FeesType::class, inversedBy: 'fees',cascade: ["persist"])]
    #[ORM\JoinColumn(nullable: false)]
    private $type;

    #[ORM\ManyToOne(inversedBy: 'fees')]
    private ?Events $events = null;

    public function __construct()
    {

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getType(): ?FeesType
    {
        return $this->type;
    }

    public function setType(?FeesType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getEvents(): ?Events
    {
        return $this->events;
    }

    public function setEvents(?Events $events): static
    {
        $this->events = $events;

        return $this;
    }

}
