<?php

namespace App\Entity;

use App\Repository\HealthEducationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HealthEducationRepository::class)]
class HealthEducation
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
    private ?float $self_rated_health = null;

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

    public function getSelfRatedHealth(): ?float
    {
        return $this->self_rated_health;
    }

    public function setSelfRatedHealth(float $self_rated_health): self
    {
        $this->self_rated_health = $self_rated_health;

        return $this;
    }
}
