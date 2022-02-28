<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandesRepository::class)]
class Commandes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Ventes::class, inversedBy: 'commandes')]
    private $ventes;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVentes(): ?Ventes
    {
        return $this->ventes;
    }

    public function setVentes(?Ventes $ventes): self
    {
        $this->ventes = $ventes;

        return $this;
    }
}
