<?php

namespace App\DTO;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

class EmploisByDateRequestDTO
{
    #[Assert\NotBlank]
    private DateTimeInterface $dateDebut;

    #[Assert\NotBlank]
    private DateTimeInterface $dateFin;

    public function __construct(
        DateTimeInterface $dateDebut,
        DateTimeInterface $dateFin
    )
    {
        $this->dateDebut = $dateDebut;
        $this->dateFin = $dateFin;
    }

    public function getDateDebut(): DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(DateTimeInterface $dateDebut): void
    {
        $this->dateDebut = $dateDebut;
    }

    public function getDateFin(): DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(DateTimeInterface $dateFin): void
    {
        $this->dateFin = $dateFin;
    }
}
