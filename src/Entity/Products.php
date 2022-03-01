<?php

namespace App\Entity;

use App\Repository\ProductsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductsRepository::class)]
class Products
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $ref;

    #[ORM\ManyToOne(targetEntity: Types::class, inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private $types;

    #[ORM\Column(type: 'string', length: 5, nullable: true)]
    private $taille;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $prix;

    #[ORM\Column(type: 'string', length: 5, nullable: true)]
    private $code;

    #[ORM\Column(type: 'string', length: 255)]
    private $designation;

    #[ORM\Column(type: 'integer')]
    private $stock = 0;

    #[ORM\Column(type: 'string', length: 5, nullable: true)]
    private $genre;

    #[ORM\ManyToMany(targetEntity: Sales::class, mappedBy: 'products')]
    private $sales;

    public function __construct()
    {
        $this->sales = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRef(): ?string
    {
        return $this->ref;
    }

    public function setRef(string $ref): self
    {
        $this->ref = $ref;

        return $this;
    }

    public function getTypes(): ?Types
    {
        return $this->types;
    }

    public function setTypes(?Types $types): self
    {
        $this->types = $types;

        return $this;
    }

    public function getTaille(): ?string
    {
        return $this->taille;
    }

    public function setTaille(?string $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(?int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): self
    {
        $this->genre = $genre;

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
            $vente->addProduit($this);
        }

        return $this;
    }

    public function removeVente(Sales $vente): self
    {
        if ($this->sales->removeElement($vente)) {
            $vente->removeProduit($this);
        }

        return $this;
    }
}
