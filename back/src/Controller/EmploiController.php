<?php

namespace App\Controller;

use App\DTO\AddEmploiRequestDTO;
use App\DTO\EmploisByDateRequestDTO;
use App\Entity\Personne;
use App\Enum\ResponseCodeEnum;
use App\Enum\ResponsemessageEnum;
use App\Service\EmploiService;
use App\Service\PersonneService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/emploi')]
class EmploiController extends AbstractController
{
    #[Route('/add/{idPersonne}', methods: ['POST'])]
    public function add(int $idPersonne, Request $request, PersonneService $personneService,  SerializerInterface $serializer, EmploiService $emploiService): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!is_array($data) || !isset($data['nomEntreprise']) || !isset($data['poste']) || !isset($data['dateDebut'])) {
            return $this->json([
                'code' => ResponseCodeEnum::MISSING_PARAMETERS,
                'message' => ResponsemessageEnum::MISSING_PARAMETERS,
            ], Response::HTTP_BAD_REQUEST, [], [
                'json_encode_options' => JSON_UNESCAPED_UNICODE
            ]);
        }

        if (isset($data['dateFin']) && $data['dateFin'] === '') {
            $data['dateFin'] = null;
        }

        $personne = $personneService->getPersonne($idPersonne);

        if (!$personne instanceof Personne) {
            return $this->json([
                'code' => ResponseCodeEnum::PERSONNE_NOT_FOUND,
                'message' => ResponsemessageEnum::PERSONNE_NOT_FOUND,
            ], Response::HTTP_NOT_FOUND, [], [
                'json_encode_options' => JSON_UNESCAPED_UNICODE
            ]);
        }

        $addEmploiRequestDTO = $serializer->deserialize(json_encode($data), AddEmploiRequestDTO::class, 'json');

        $response = $emploiService->add($addEmploiRequestDTO, $personne);

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

    #[Route('/all/{idPersonne}', methods: ['GET'])]
    public function getEmploisByDate(int $idPersonne, Request $request, SerializerInterface $serializer, PersonneService $personneService, EmploiService $emploiService): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!is_array($data) || !isset($data['dateDebut']) || !isset($data['dateFin'])) {
            return $this->json([
                'code' => ResponseCodeEnum::MISSING_PARAMETERS,
                'message' => ResponsemessageEnum::MISSING_PARAMETERS,
            ], Response::HTTP_BAD_REQUEST, [], [
                'json_encode_options' => JSON_UNESCAPED_UNICODE
            ]);
        }

        $personne = $personneService->getPersonne($idPersonne);

        if (!$personne instanceof Personne) {
            return $this->json([
                'code' => ResponseCodeEnum::PERSONNE_NOT_FOUND,
                'message' => ResponsemessageEnum::PERSONNE_NOT_FOUND,
            ], Response::HTTP_NOT_FOUND, [], [
                'json_encode_options' => JSON_UNESCAPED_UNICODE
            ]);
        }

        $emploisByDateRequestDTO = $serializer->deserialize(json_encode($data), EmploisByDateRequestDTO::class, 'json');
        $emplois = $emploiService->getEmploisByDate($emploisByDateRequestDTO, $personne);

        return new JsonResponse($emplois);
    }
}
