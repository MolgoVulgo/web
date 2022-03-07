<?php

namespace App\Entity;

use App\Repository\orderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Invoices::class, inversedBy: 'order')]
    private $invoices;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInvoices(): ?Invoices
    {
        return $this->invoices;
    }

    public function setInvoices(?Invoices $invoices): self
    {
        $this->invoices = $invoices;

        return $this;
    }
}
