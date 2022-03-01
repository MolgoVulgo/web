<?php

namespace App\Entity;

use App\Repository\EventsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventsRepository::class)]
class Events
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $location;

    #[ORM\Column(type: 'date', nullable: true)]
    private $date;

    #[ORM\ManyToMany(targetEntity: Fees::class, inversedBy: 'events', cascade: ["persist"])]
    private $fees;

    #[ORM\OneToMany(mappedBy: 'events', targetEntity: Sales::class)]
    private $sales;

    public function __construct()
    {
        $this->fees = new ArrayCollection();
        $this->sales = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection<int, Fees>
     */
    public function getFees(): Collection
    {
        return $this->fees;
    }

    public function addFees(Fees $fees): self
    {
        if (!$this->fees->contains($fees)) {
            $this->fees[] = $fees;
        }

        return $this;
    }

    public function removeFees(Fees $fees): self
    {
        $this->fees->removeElement($fees);

        return $this;
    }

    /**
     * @return Collection<int, Sales>
     */
    public function getSales(): Collection
    {
        return $this->sales;
    }

    public function addVente(Sales $vente): self
    {
        if (!$this->sales->contains($vente)) {
            $this->sales[] = $vente;
            $vente->setEvents($this);
        }

        return $this;
    }

    public function removeVente(Sales $vente): self
    {
        if ($this->sales->removeElement($vente)) {
            // set the owning side to null (unless already changed)
            if ($vente->getEvents() === $this) {
                $vente->setEvents(null);
            }
        }

        return $this;
    }

}
