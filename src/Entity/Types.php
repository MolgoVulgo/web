<?php

namespace App\Entity;

use App\Repository\TypesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypesRepository::class)]
class Types
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\OneToMany(mappedBy: 'types', targetEntity: Products::class)]
    private $products;

    #[ORM\Column(type: 'text', nullable: true)]
    private $commentaire;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Products>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduit(Products $produit): self
    {
        if (!$this->products->contains($produit)) {
            $this->products[] = $produit;
            $produit->setTypes($this);
        }

        return $this;
    }

    public function removeProduit(Products $produit): self
    {
        if ($this->products->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getTypes() === $this) {
                $produit->setTypes(null);
            }
        }

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }
}
