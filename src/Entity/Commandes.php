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

    #[ORM\ManyToOne(targetEntity: Sales::class, inversedBy: 'commandes')]
    private $sales;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSales(): ?Sales
    {
        return $this->sales;
    }

    public function setSales(?Sales $sales): self
    {
        $this->sales = $sales;

        return $this;
    }
}
