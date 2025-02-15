<?php

namespace App\Service;

use App\DTO\AddEmploiRequestDTO;
use App\DTO\EmploiDTO;
use App\DTO\EmploisByDateRequestDTO;
use App\Entity\Emploi;
use App\Entity\Personne;
use App\Enum\ResponseCodeEnum;
use App\Enum\ResponsemessageEnum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EmploiService
{
    public function __construct(
        private readonly ValidatorInterface     $validator,
        private readonly ViolationService       $violationService,
        private readonly EntityManagerInterface $entityManager,
    )
    {
    }

    public function add(AddEmploiRequestDTO $addEmploiRequestDTO, Personne $personne): array
    {
        $violations = $this->validator->validate($addEmploiRequestDTO);

        if (count($violations) > 0) {
            $errors = $this->violationService->formatViolations($violations);
            return ['code' => ResponseCodeEnum::POST_INVALID_DATA, 'message' => ResponsemessageEnum::POST_INVALID_DATA, 'errors' => $errors];
        }

        $emploi = new Emploi();
        $emploi->setNomEntreprise($addEmploiRequestDTO->getNomEntreprise())
            ->setPoste($addEmploiRequestDTO->getPoste())
            ->setDateDebut($addEmploiRequestDTO->getDateDebut())
            ->setDateFin($addEmploiRequestDTO->getDateFin())
            ->setPersonne($personne);

        $errors = $this->validator->validate($emploi);
        if (count($errors) > 0) {
            return ['code' => ResponseCodeEnum::ENTITY_INVALID_DATA, 'message' => ResponsemessageEnum::ENTITY_INVALID_DATA, 'errors' => $errors];
        }

        $this->entityManager->persist($emploi);
        $this->entityManager->flush();

        return ['code' => ResponseCodeEnum::ADD_EMPLOI_SUCCES, 'message' => ResponsemessageEnum::ADD_EMPLOI_SUCCES];
    }

    public function getEmploisByDate(EmploisByDateRequestDTO $emploisByDateRequestDTO, Personne $personne): array
    {
        $dateDebut = $emploisByDateRequestDTO->getDateDebut();
        $dateFin = $emploisByDateRequestDTO->getDateFin();

        $emploisInRange = [];

        foreach ($personne->getEmplois() as $emploi) {
            $emploiDateDebut = $emploi->getDateDebut();
            $emploiDateFin = $emploi->getDateFin();

            if (($emploiDateDebut <= $dateFin && ($emploiDateFin === null || $emploiDateFin >= $dateDebut))) {
                $emploisInRange[] = new EmploiDTO(
                    $emploi->getNomEntreprise(),
                    $emploi->getPoste(),
                    $emploi->getDateDebut(),
                    $emploi->getDateFin()
                );
            }
        }

        return $emploisInRange;
    }
}