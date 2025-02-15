<?php

namespace App\Controller;

use App\DTO\NewPersonneRequestDTO;
use App\Entity\Emploi;
use App\Enum\ResponseCodeEnum;
use App\Enum\ResponsemessageEnum;
use App\Service\PersonneService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/personne')]
class PersonneController extends AbstractController
{
    #[Route('/new', methods: ['POST'])]
    public function new(Request $request, PersonneService $personneService, SerializerInterface $serializer): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!is_array($data) || !isset($data['nom']) || !isset($data['prenom']) || !isset($data['dateNaissance'])) {
            return $this->json([
                'code' => ResponseCodeEnum::MISSING_PARAMETERS,
                'message' => ResponsemessageEnum::MISSING_PARAMETERS,
            ], Response::HTTP_BAD_REQUEST, [], [
                'json_encode_options' => JSON_UNESCAPED_UNICODE
            ]);
        }

        try {
            $dateNaissance = new \DateTime($data['dateNaissance']);
        } catch (\Exception $e) {
            return $this->json([
                'code' => ResponseCodeEnum::DATE_FORMAT,
                'message' => ResponsemessageEnum::DATE_FORMAT,
            ], Response::HTTP_BAD_REQUEST, [], [
                'json_encode_options' => JSON_UNESCAPED_UNICODE
            ]);
        }

        $currentDate = new \DateTime();
        $age = $currentDate->diff($dateNaissance)->y;

        if ($age > 150) {
            return $this->json([
                'code' => ResponseCodeEnum::MAX_AGE,
                'message' => ResponsemessageEnum::MAX_AGE,
            ], Response::HTTP_BAD_REQUEST, [], [
                'json_encode_options' => JSON_UNESCAPED_UNICODE
            ]);
        }

        $newPersonneRequestDTO = $serializer->deserialize(json_encode($data), NewPersonneRequestDTO::class, 'json');

        $response = $personneService->new($newPersonneRequestDTO);

        if (isset($response['errors'])) {
            return $this->json([
                'code' => $response['code'],
                'message' => $response['message'],
                'errors' => $response['errors'],
            ], Response::HTTP_BAD_REQUEST, [], [
                'json_encode_options' => JSON_UNESCAPED_UNICODE
            ]);
        }

        return $this->json([
            'code' => $response['code'],
            'message' => $response['message'],
        ], Response::HTTP_OK, [], [
            'json_encode_options' => JSON_UNESCAPED_UNICODE
        ]);
    }

    #[Route('/all', methods: ['GET'])]
    public function getPersonnes(PersonneService $personneService): JsonResponse
    {
        $personnes = $personneService->getPersonnes();
        return new JsonResponse($personnes);
    }

    #[Route('/all/{nomEntreprise}', methods: ['GET'])]
    public function getPersonnesByEntreprise(string $nomEntreprise, EntityManagerInterface $entityManager, PersonneService $personneService): JsonResponse
    {
        $personnes =  $personneService->getPersonnesByEntreprise($nomEntreprise);
        return new JsonResponse($personnes);
    }
}