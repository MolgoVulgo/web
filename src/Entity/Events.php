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
    private $startDate;

    #[ORM\Column(type: 'date', nullable: true)]
    private $endDate;

    #[ORM\OneToMany(mappedBy: 'events', targetEntity: Invoices::class)]
    private $invoices;

    #[ORM\OneToMany(mappedBy: 'events', targetEntity: Fees::class,cascade: ["persist"])]
    private Collection $fees;

    public function __construct()
    {
        $this->invoices = new ArrayCollection();
        $this->fees = new ArrayCollection();
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

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * @return Collection<int, Invoices>
     */
    public function getInvoices(): Collection
    {
        return $this->invoices;
    }

    public function addInvoices(Invoices $invoices): self
    {
        if (!$this->invoices->contains($invoices)) {
            $this->invoices[] = $invoices;
            $invoices->setEvents($this);
        }

        return $this;
    }

    public function removeInvoices(Invoices $invoices): self
    {
        if ($this->invoices->removeElement($invoices)) {
            // set the owning side to null (unless already changed)
            if ($invoices->getEvents() === $this) {
                $invoices->setEvents(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Fees>
     */
    public function getFees(): Collection
    {
        return $this->fees;
    }

    public function addFee(Fees $fee): static
    {
        if (!$this->fees->contains($fee)) {

            $this->fees->add($fee);
            $fee->setEvents($this);
        }

        return $this;
    }

    public function removeFee(Fees $fee): static
    {
        if ($this->fees->removeElement($fee)) {
            // set the owning side to null (unless already changed)
            if ($fee->getEvents() === $this) {
                $fee->setEvents(null);
            }
        }

        return $this;
    }

}
