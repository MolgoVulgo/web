<?php

namespace App\Entity;

use App\Repository\EvenementsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EvenementsRepository::class)]
class Evenements
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $nom;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $lieu;

    #[ORM\Column(type: 'date', nullable: true)]
    private $date;

    #[ORM\ManyToMany(targetEntity: Frais::class, inversedBy: 'evenements', cascade: ["persist"])]
    private $frais;

    #[ORM\OneToMany(mappedBy: 'events', targetEntity: Sales::class)]
    private $sales;

    public function __construct()
    {
        $this->frais = new ArrayCollection();
        $this->sales = new ArrayCollection();
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

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

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
     * @return Collection<int, Frais>
     */
    public function getFrais(): Collection
    {
        return $this->frais;
    }

    public function addFrai(Frais $frai): self
    {
        if (!$this->frais->contains($frai)) {
            $this->frais[] = $frai;
        }

        return $this;
    }

    public function removeFrai(Frais $frai): self
    {
        $this->frais->removeElement($frai);

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
