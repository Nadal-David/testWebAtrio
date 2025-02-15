<?php

namespace App\Service;

use App\DTO\EmploiDTO;
use App\DTO\NewPersonneRequestDTO;
use App\DTO\PersonneDTO;
use App\Entity\Emploi;
use App\Entity\Personne;
use App\Enum\ResponseCodeEnum;
use App\Enum\ResponsemessageEnum;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PersonneService
{
    public function __construct(
        private readonly ValidatorInterface     $validator,
        private readonly ViolationService       $violationService,
        private readonly EntityManagerInterface $entityManager,
    )
    {
    }

    public function new(NewPersonneRequestDTO $newPersonneRequestDTO): array
    {
        $violations = $this->validator->validate($newPersonneRequestDTO);

        if (count($violations) > 0) {
            $errors = $this->violationService->formatViolations($violations);
            return ['code' => ResponseCodeEnum::POST_INVALID_DATA, 'message' => ResponsemessageEnum::POST_INVALID_DATA, 'errors' => $errors];
        }

        $personne = new Personne();
        $personne->setNom($newPersonneRequestDTO->getNom())
            ->setPrenom($newPersonneRequestDTO->getPrenom())
            ->setDateNaissance($newPersonneRequestDTO->getDateNaissance());


        $errors = $this->validator->validate($personne);
        if (count($errors) > 0) {
            return ['code' => ResponseCodeEnum::ENTITY_INVALID_DATA, 'message' => ResponsemessageEnum::ENTITY_INVALID_DATA, 'errors' => $errors];
        }

        $this->entityManager->persist($personne);
        $this->entityManager->flush();

        return ['code' => ResponseCodeEnum::NEW_PERSONNE_SUCCES, 'message' => ResponsemessageEnum::NEW_PERSONNE_SUCCES];
    }

    public function getPersonne(int $id): ?Personne
    {
        return $this->entityManager->getRepository(Personne::class)->find($id);
    }

    public function getPersonnes(): array
    {
        $personnes = $this->entityManager->getRepository(Personne::class)->findBy([], ['nom' => 'ASC']);
        $data = new ArrayCollection();

        $currentDate = new \DateTime();

        foreach ($personnes as $personne) {
            $emploisActuels = new ArrayCollection();
            foreach ($personne->getEmplois() as $emploi) {
                if (!$emploi->getDateFin() || $emploi->getDateFin() > $currentDate) {
                    $emploisActuels->add(new EmploiDTO(
                        $emploi->getNomEntreprise(),
                        $emploi->getPoste(),
                        $emploi->getDateDebut(),
                        $emploi->getDateFin(),
                    ));
                }
            }


            $data->add(new PersonneDTO(
                $personne->getId(),
                $personne->getNom(),
                $personne->getPrenom(),
                $personne->getDateNaissance()->diff(new \DateTime())->y,
                $emploisActuels->toArray()
            ));
        }

        return $data->toArray();
    }

    public function getPersonnesByEntreprise(string $nomEntreprise): array
    {
        $emplois = $this->entityManager->getRepository(Emploi::class)->findBy(['nomEntreprise' => $nomEntreprise]);
        $data = new ArrayCollection();
        $personnesAjoutees = new ArrayCollection();

        foreach ($emplois as $emploi) {
            $personne = $emploi->getPersonne();

            if (!$personnesAjoutees->containsKey($personne->getId())) {
                $personneDTO = new PersonneDTO(
                    $personne->getId(),
                    $personne->getNom(),
                    $personne->getPrenom(),
                    $personne->getDateNaissance()->diff(new \DateTime())->y
                );

                if (empty($personneDTO->emploisActuels)) {
                    unset($personneDTO->emploisActuels);
                }

                $personnesAjoutees->set($personne->getId(), true);

                $data->add($personneDTO);
            }
        }

        return $data->toArray();
    }
}