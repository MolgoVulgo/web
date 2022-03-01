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

    #[ORM\ManyToOne(targetEntity: Evenements::class, inversedBy: 'sales', cascade: ["persist"])]
    private $events;

    #[ORM\OneToMany(mappedBy: 'sales', targetEntity: Commandes::class, cascade: ["persist"])]
    private $commandes;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->commandes = new ArrayCollection();
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

    public function getEvents(): ?Evenements
    {
        return $this->events;
    }

    public function setEvents(?Evenements $events): self
    {
        $this->events = $events;

        return $this;
    }

    /**
     * @return Collection<int, Commandes>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commandes $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setSales($this);
        }

        return $this;
    }

    public function removeCommande(Commandes $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getSales() === $this) {
                $commande->setSales(null);
            }
        }

        return $this;
    }
}
