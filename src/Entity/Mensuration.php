<?php

namespace App\Entity;

use App\Repository\MensurationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MensurationRepository::class)]
class Mensuration
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $hauteurTailleSol;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $longueurBasLegerementPlie;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $hauteurEncolureSol;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $taille;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $tourCou;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $carrureDevant;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $carrureDos;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $tourPoitrine;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $tourSousPoitrine;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $tourTaille;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $tourHanche;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $tourBassin;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $tourGenou;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $tourCheville;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $encartSaillantPoitrine;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $hauteurEcolureTailleDevant;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $hauteurEncolurSaillant;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $hauteurTailleGenou;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $tourBiceps;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $tourAvantBras;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $tourPoignet;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $tourCuisse;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $tourMollet;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $hauteurEncolureTailleDos;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHauteurTailleSol(): ?int
    {
        return $this->hauteurTailleSol;
    }

    public function setHauteurTailleSol(?int $hauteurTailleSol): self
    {
        $this->hauteurTailleSol = $hauteurTailleSol;

        return $this;
    }

    public function getLongueurBasLegerementPlie(): ?int
    {
        return $this->longueurBasLegerementPlie;
    }

    public function setLongueurBasLegerementPlie(?int $longueurBasLegerementPlie): self
    {
        $this->longueurBasLegerementPlie = $longueurBasLegerementPlie;

        return $this;
    }

    public function getHauteurEncolureSol(): ?int
    {
        return $this->hauteurEncolureSol;
    }

    public function setHauteurEncolureSol(?int $hauteurEncolureSol): self
    {
        $this->hauteurEncolureSol = $hauteurEncolureSol;

        return $this;
    }

    public function getTaille(): ?int
    {
        return $this->taille;
    }

    public function setTaille(?int $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

    public function getTourCou(): ?int
    {
        return $this->tourCou;
    }

    public function setTourCou(?int $tourCou): self
    {
        $this->tourCou = $tourCou;

        return $this;
    }

    public function getCarrureDevant(): ?int
    {
        return $this->carrureDevant;
    }

    public function setCarrureDevant(?int $carrureDevant): self
    {
        $this->carrureDevant = $carrureDevant;

        return $this;
    }

    public function getCarrureDos(): ?int
    {
        return $this->carrureDos;
    }

    public function setCarrureDos(?int $carrureDos): self
    {
        $this->carrureDos = $carrureDos;

        return $this;
    }

    public function getTourPoitrine(): ?int
    {
        return $this->tourPoitrine;
    }

    public function setTourPoitrine(?int $tourPoitrine): self
    {
        $this->tourPoitrine = $tourPoitrine;

        return $this;
    }

    public function getTourSousPoitrine(): ?int
    {
        return $this->tourSousPoitrine;
    }

    public function setTourSousPoitrine(?int $tourSousPoitrine): self
    {
        $this->tourSousPoitrine = $tourSousPoitrine;

        return $this;
    }

    public function getTourTaille(): ?int
    {
        return $this->tourTaille;
    }

    public function setTourTaille(?int $tourTaille): self
    {
        $this->tourTaille = $tourTaille;

        return $this;
    }

    public function getTourHanche(): ?int
    {
        return $this->tourHanche;
    }

    public function setTourHanche(?int $tourHanche): self
    {
        $this->tourHanche = $tourHanche;

        return $this;
    }

    public function getTourBassin(): ?int
    {
        return $this->tourBassin;
    }

    public function setTourBassin(?int $tourBassin): self
    {
        $this->tourBassin = $tourBassin;

        return $this;
    }

    public function getTourGenou(): ?int
    {
        return $this->tourGenou;
    }

    public function setTourGenou(?int $tourGenou): self
    {
        $this->tourGenou = $tourGenou;

        return $this;
    }

    public function getTourCheville(): ?int
    {
        return $this->tourCheville;
    }

    public function setTourCheville(?int $tourCheville): self
    {
        $this->tourCheville = $tourCheville;

        return $this;
    }

    public function getEncartSaillantPoitrine(): ?int
    {
        return $this->encartSaillantPoitrine;
    }

    public function setEncartSaillantPoitrine(?int $encartSaillantPoitrine): self
    {
        $this->encartSaillantPoitrine = $encartSaillantPoitrine;

        return $this;
    }

    public function getHauteurEcolureTailleDevant(): ?int
    {
        return $this->hauteurEcolureTailleDevant;
    }

    public function setHauteurEcolureTailleDevant(?int $hauteurEcolureTailleDevant): self
    {
        $this->hauteurEcolureTailleDevant = $hauteurEcolureTailleDevant;

        return $this;
    }

    public function getHauteurEncolurSaillant(): ?int
    {
        return $this->hauteurEncolurSaillant;
    }

    public function setHauteurEncolurSaillant(?int $hauteurEncolurSaillant): self
    {
        $this->hauteurEncolurSaillant = $hauteurEncolurSaillant;

        return $this;
    }

    public function getHauteurTailleGenou(): ?int
    {
        return $this->hauteurTailleGenou;
    }

    public function setHauteurTailleGenou(?int $hauteurTailleGenou): self
    {
        $this->hauteurTailleGenou = $hauteurTailleGenou;

        return $this;
    }

    public function getTourBiceps(): ?int
    {
        return $this->tourBiceps;
    }

    public function setTourBiceps(?int $tourBiceps): self
    {
        $this->tourBiceps = $tourBiceps;

        return $this;
    }

    public function getTourAvantBras(): ?int
    {
        return $this->tourAvantBras;
    }

    public function setTourAvantBras(?int $tourAvantBras): self
    {
        $this->tourAvantBras = $tourAvantBras;

        return $this;
    }

    public function getTourPoignet(): ?int
    {
        return $this->tourPoignet;
    }

    public function setTourPoignet(?int $tourPoignet): self
    {
        $this->tourPoignet = $tourPoignet;

        return $this;
    }

    public function getTourCuisse(): ?int
    {
        return $this->tourCuisse;
    }

    public function setTourCuisse(?int $tourCuisse): self
    {
        $this->tourCuisse = $tourCuisse;

        return $this;
    }

    public function getTourMollet(): ?int
    {
        return $this->tourMollet;
    }

    public function setTourMollet(?int $tourMollet): self
    {
        $this->tourMollet = $tourMollet;

        return $this;
    }

    public function getHauteurEncolureTailleDos(): ?int
    {
        return $this->hauteurEncolureTailleDos;
    }

    public function setHauteurEncolureTailleDos(?int $hauteurEncolureTailleDos): self
    {
        $this->hauteurEncolureTailleDos = $hauteurEncolureTailleDos;

        return $this;
    }
}
