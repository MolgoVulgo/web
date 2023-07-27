<?php

namespace App\Entity;

use App\Repository\InvoicesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InvoicesRepository::class)]
class Invoices
{
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Customers::class, inversedBy: 'invoices', cascade: ["persist"])]
    private $customer;

    // #[ORM\ManyToMany(targetEntity: Products::class, inversedBy: 'invoices', cascade: ["all"])]
    // private $products;

    #[ORM\ManyToOne(targetEntity: Events::class, inversedBy: 'invoices', cascade: ["persist"])]
    private $events;

    #[ORM\ManyToMany(targetEntity: InvoiceLines::class, inversedBy: 'invoices', cascade: ["persist"])]
    private $invoiceLines;

    #[ORM\Column(type: 'date')]
    private $date;

    #[ORM\Column(type: 'integer')]
    private $type = 1;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $downPayment;

    public function __construct()
    {
        //$this->products = new ArrayCollection();
        $this->invoiceLines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomer(): ?Customers
    {
        return $this->customer;
    }

    public function setCustomer(?Customers $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    // /**
    //  * @return Collection<int, Products>
    //  */
    // public function getProducts(): Collection
    // {
    //     return $this->products;
    // }

    // public function addProducts(Products $article): self
    // {
    //     if (!$this->products->contains($article)) {
    //         $this->products[] = $article;
    //     }

    //     return $this;
    // }

    // public function removeProducts(Products $article): self
    // {
    //     $this->products->removeElement($article);

    //     return $this;
    // }

    public function getEvents(): ?Events
    {
        return $this->events;
    }

    public function setEvents(?Events $events): self
    {
        $this->events = $events;

        return $this;
    }

    /**
     * @return Collection<int, InvoiceLines>
     */
    public function getInvoiceLines(): Collection
    {
        return $this->invoiceLines;
    }

    public function addInvoiceLine(InvoiceLines $invoiceLine): self
    {
        if (!$this->invoiceLines->contains($invoiceLine)) {
            $this->invoiceLines[] = $invoiceLine;
        }

        return $this;
    }

    public function removeInvoiceLine(InvoiceLines $invoiceLine): self
    {
        $this->invoiceLines->removeElement($invoiceLine);

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

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDownPayment(): ?int
    {
        return $this->downPayment;
    }

    public function setDownPayment(?int $downPayment): self
    {
        $this->downPayment = $downPayment;

        return $this;
    }

}
