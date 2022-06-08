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


    #[ORM\ManyToMany(targetEntity: Fees::class, inversedBy: 'events', cascade: ["persist"])]
    private $fees;

    #[ORM\OneToMany(mappedBy: 'events', targetEntity: Invoices::class)]
    private $invoices;

    public function __construct()
    {
        $this->fees = new ArrayCollection();
        $this->invoices = new ArrayCollection();
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

}
