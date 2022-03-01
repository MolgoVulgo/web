<?php

namespace App\Entity;

use App\Repository\SalesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SalesRepository::class)]
class Sales
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Customers::class, inversedBy: 'sales', cascade: ["persist"])]
    private $customer;

    #[ORM\ManyToMany(targetEntity: Products::class, inversedBy: 'sales', cascade: ["all"])]
    private $products;

    #[ORM\ManyToOne(targetEntity: Events::class, inversedBy: 'sales', cascade: ["persist"])]
    private $events;

    #[ORM\OneToMany(mappedBy: 'sales', targetEntity: Order::class, cascade: ["persist"])]
    private $order;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->order = new ArrayCollection();
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

    /**
     * @return Collection<int, Products>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProducts(Products $article): self
    {
        if (!$this->products->contains($article)) {
            $this->products[] = $article;
        }

        return $this;
    }

    public function removeProducts(Products $article): self
    {
        $this->products->removeElement($article);

        return $this;
    }

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
     * @return Collection<int, Order>
     */
    public function getOrder(): Collection
    {
        return $this->order;
    }

    public function addorder(Order $order): self
    {
        if (!$this->order->contains($order)) {
            $this->order[] = $order;
            $order->setSales($this);
        }

        return $this;
    }

    public function removeorder(Order $order): self
    {
        if ($this->order->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getSales() === $this) {
                $order->setSales(null);
            }
        }

        return $this;
    }
}
