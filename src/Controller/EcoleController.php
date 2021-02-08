<?php

namespace App\Controller;

use App\Repository\EcoleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class EcoleController extends AbstractController
{
    private $serializer;

    public function __construct()
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];

        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getNom();
            },
        ];

        $normalizer = [new ObjectNormalizer(null, null, null, null, null, null, $defaultContext)];

        $this->serializer= new Serializer($normalizer, $encoders);
    }

    /**
     * @Route("/ecole", name="ecole", methods={"GET"})
     * @param EcoleRepository $ecoleRepository
     * @return Response
     */
    public function index(EcoleRepository $ecoleRepository): Response
    {
        $ecole = $ecoleRepository->findAll();

        $jsonContent = $this->serializer->serialize($ecole, 'json');

        $response = JsonResponse::fromJsonString($jsonContent);

        return $response;
    }
}
