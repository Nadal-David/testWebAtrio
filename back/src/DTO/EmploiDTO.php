<?php

namespace App\DTO;

use DateTimeInterface;

class EmploiDTO
{
    public string $nomEntreprise;
    public string $poste;
    public DateTimeInterface $dateDebut;
    public ?DateTimeInterface $dateFin;

    public function __construct(
        string            $nomEntreprise,
        string            $poste,
        DateTimeInterface $dateDebut,
        ?DateTimeInterface $dateFin
    )
    {
        $this->nomEntreprise = $nomEntreprise;
        $this->poste = $poste;
        $this->dateDebut = $dateDebut;
        $this->dateFin = $dateFin;
    }
}
