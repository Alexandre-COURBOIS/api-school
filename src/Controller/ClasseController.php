<?php

namespace App\Controller;

use App\Repository\ClasseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ClasseController extends AbstractController
{

    private $serializer;

    public function __construct()
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $this->serializer= new Serializer($normalizers, $encoders);
    }

    /**
     * @Route("/classe", name="classe", methods={"GET"})
     * @param ClasseRepository $classeRepository
     * @return Response
     */
    public function index(ClasseRepository $classeRepository): Response
    {
        $classe = $classeRepository->findAll();

        $jsonContent = $this->serializer->serialize($classe, 'json');

        $response = JsonResponse::fromJsonString($jsonContent);

        return $response;
    }
}
