<?php

namespace App\Controller;

use App\Repository\EleveRepository;
use App\Service\SerializerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EleveController extends AbstractController
{
    private SerializerService $serializerService;

    public function __construct(serializerService $serializer)
    {

        $this->serializerService = $serializer;

    }


    /**
     * @Route("/eleve", name="eleve", methods={"GET"})
     * @param EleveRepository $eleveRepository
     * @return Response
     */
    public function index(EleveRepository $eleveRepository): Response
    {
        $eleve = $eleveRepository->findAll();

        $jsonContent = $this->serializerService->RelationSerializer($eleve, 'json');

        $response = JsonResponse::fromJsonString($jsonContent);

        return $response;
    }
}
