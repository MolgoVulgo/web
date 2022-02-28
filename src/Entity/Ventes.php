<?php

namespace App\Entity;

use App\Repository\VentesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VentesRepository::class)]
class Ventes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Clients::class, inversedBy: 'ventes', cascade: ["persist"])]
    private $client;

    #[ORM\ManyToMany(targetEntity: Produits::class, inversedBy: 'ventes', cascade: ["all"])]
    private $produits;

    #[ORM\ManyToOne(targetEntity: Evenements::class, inversedBy: 'ventes', cascade: ["persist"])]
    private $events;

    #[ORM\OneToMany(mappedBy: 'ventes', targetEntity: Commandes::class, cascade: ["persist"])]
    private $commandes;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?Clients
    {
        return $this->client;
    }

    public function setClient(?Clients $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection<int, Produits>
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produits $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits[] = $produit;
        }

        return $this;
    }

    public function removeProduit(Produits $produit): self
    {
        $this->produits->removeElement($produit);

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
            $commande->setVentes($this);
        }

        return $this;
    }

    public function removeCommande(Commandes $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getVentes() === $this) {
                $commande->setVentes(null);
            }
        }

        return $this;
    }
}
