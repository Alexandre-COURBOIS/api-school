<?php

namespace App\Controller;

use App\Repository\EcoleRepository;
use App\Service\SerializerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EcoleController extends AbstractController
{
    private SerializerService $serializerService;

    public function __construct(serializerService $serializer)
    {

        $this->serializerService = $serializer;

    }

    /**
     * @Route("/ecole", name="ecole", methods={"GET"})
     * @param EcoleRepository $ecoleRepository
     * @return Response
     */
    public function index(EcoleRepository $ecoleRepository): Response
    {
//        $ecole = $ecoleRepository->findAll();
//
//        $jsonContent = $this->serializerService->RelationSerializer($ecole, 'json');
//
//        $response = JsonResponse::fromJsonString($jsonContent);
//
//        return $response;

        return JsonResponse::fromJsonString($this->serializerService->RelationSerializer($ecoleRepository->findAll(),'json'));
    }
}
