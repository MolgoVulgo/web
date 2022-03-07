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

    // #[ORM\OneToMany(mappedBy: 'invoices', targetEntity: Order::class, cascade: ["persist"])]
    // private $order;

    #[ORM\ManyToMany(targetEntity: InvoiceLines::class, inversedBy: 'invoices', cascade: ["persist"])]
    private $invoiceLines;

    #[ORM\Column(type: 'date', options: ["default" => 'CURRENT_TIMESTAMP'])]
    private $date;

    public function __construct()
    {
        //$this->products = new ArrayCollection();
        //$this->order = new ArrayCollection();
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

    // /**
    //  * @return Collection<int, Order>
    //  */
    // public function getOrder(): Collection
    // {
    //     return $this->order;
    // }

    // public function addorder(Order $order): self
    // {
    //     if (!$this->order->contains($order)) {
    //         $this->order[] = $order;
    //         $order->setSales($this);
    //     }

    //     return $this;
    // }

    // public function removeorder(Order $order): self
    // {
    //     if ($this->order->removeElement($order)) {
    //         // set the owning side to null (unless already changed)
    //         if ($order->getSales() === $this) {
    //             $order->setSales(null);
    //         }
    //     }

    //     return $this;
    // }

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
}
