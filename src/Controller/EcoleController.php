<?php

namespace App\Controller;

use App\Entity\Ecole;
use App\Repository\EcoleRepository;
use App\Service\SerializerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
        return JsonResponse::fromJsonString($this->serializerService->RelationSerializer($ecoleRepository->findAll(),'json'));
    }

    /**
     * @Route("/ecole/new", name="ecole_new", methods={"POST"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function newEleve(Request $request, EntityManagerInterface $em): Response
    {
        $data = json_decode($request->getContent(), true);

        $ecole = new Ecole();

        $ecole->setNom($data['nom']);
        $ecole->setAdresse($data['adresse']);
        $ecole->setCreatedAt(new \DateTime());

        $em->persist($ecole);

        $em->flush();

        return new JsonResponse("Ecole ajoute", Response::HTTP_OK);
    }
}
