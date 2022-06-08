<?php

namespace App\Entity;

use App\Repository\SettingsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SettingsRepository::class)]
class Settings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'json')]
    private $codeSetting = [];

    #[ORM\Column(type: 'json')]
    private $value = [];

    #[ORM\Column(type: 'boolean')]
    private $configurable = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeSetting(): ?array
    {
        return $this->codeSetting;
    }

    public function setCodeSetting(array $codeSetting): self
    {
        $this->codeSetting = $codeSetting;

        return $this;
    }

    public function getValue(): ?array
    {
        return $this->value;
    }

    public function setValue(array $value): self
    {
        $this->value = $value;

        return $this;
    }
    
    public function getConfigurable(): ?bool
    {
        return $this->configurable;
    }

    public function setConfigurable(bool $configurable): self
    {
        $this->configurable = $configurable;

        return $this;
    }
}
