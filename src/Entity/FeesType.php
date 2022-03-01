<?php

namespace App\Entity;

use App\Repository\FeesTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FeesTypeRepository::class)]
class FeesType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 20)]
    private $code;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: Fees::class)]
    private $fees;

    public function __construct()
    {
        $this->fees = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Fees>
     */
    public function getFees(): Collection
    {
        return $this->fees;
    }

    public function addFees(Fees $fees): self
    {
        if (!$this->fees->contains($fees)) {
            $this->fees[] = $fees;
            $fees->setType($this);
        }

        return $this;
    }

    public function removeFees(Fees $fees): self
    {
        if ($this->fees->removeElement($fees)) {
            // set the owning side to null (unless already changed)
            if ($fees->getType() === $this) {
                $fees->setType(null);
            }
        }

        return $this;
    }
}
