<?php

namespace App\Entity;

use App\Repository\HealthEconomyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HealthEconomyRepository::class)]
class HealthEconomy
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $gender = null;

    #[ORM\Column(length: 255)]
    private ?string $education_level = null;

    #[ORM\Column]
    private ?float $needed_care = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getEducationLevel(): ?string
    {
        return $this->education_level;
    }

    public function setEducationLevel(string $education_level): self
    {
        $this->education_level = $education_level;

        return $this;
    }

    public function getNeededCare(): ?float
    {
        return $this->needed_care;
    }

    public function setNeededCare(float $needed_care): self
    {
        $this->needed_care = $needed_care;

        return $this;
    }
}
