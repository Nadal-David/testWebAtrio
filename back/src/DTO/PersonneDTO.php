<?php

namespace App\DTO;

class PersonneDTO
{
    public int $id;
    public string $nom;
    public string $prenom;
    public int $age;
    public ?array $emploisActuels;

    public function __construct(
        int    $id,
        string $nom,
        string $prenom,
        int    $age,
        ?array $emploisActuels = null
    )
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->age = $age;
        $this->emploisActuels = $emploisActuels ?? [];
    }
}
