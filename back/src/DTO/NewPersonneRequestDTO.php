<?php

namespace App\DTO;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

class NewPersonneRequestDTO
{
    #[Assert\NotBlank]
    #[Assert\Type("string")]
    private string $nom;

    #[Assert\NotBlank]
    #[Assert\Type("string")]
    private string $prenom;

    #[Assert\NotBlank]
    private DateTimeInterface $dateNaissance;

    public function __construct(
        string            $nom,
        string            $prenom,
        DateTimeInterface $dateNaissance
    )
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->dateNaissance = $dateNaissance;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function getDateNaissance(): DateTimeInterface
    {
        return $this->dateNaissance;
    }
}
