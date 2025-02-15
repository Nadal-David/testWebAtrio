<?php

namespace App\DTO;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

class AddEmploiRequestDTO
{
    #[Assert\NotBlank]
    #[Assert\Type("string")]
    private string $nomEntreprise;

    #[Assert\NotBlank]
    #[Assert\Type("string")]
    private string $poste;

    #[Assert\NotBlank]
    private DateTimeInterface $dateDebut;

    private ?DateTimeInterface $dateFin;


    public function __construct(
        string             $nomEntreprise,
        string             $poste,
        DateTimeInterface  $dateDebut,
        ?DateTimeInterface $dateFin
    )
    {
        $this->nomEntreprise = $nomEntreprise;
        $this->poste = $poste;
        $this->dateDebut = $dateDebut;
        $this->dateFin = $dateFin;
    }

    public function getNomEntreprise(): string
    {
        return $this->nomEntreprise;
    }

    public function getPoste(): string
    {
        return $this->poste;
    }

    public function getDateDebut(): DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function getDateFin(): ?DateTimeInterface
    {
        return $this->dateFin;
    }
}
