<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Repository\ClasseRepository;
use App\Repository\EcoleRepository;
use App\Service\SerializerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClasseController extends AbstractController
{

    private SerializerService $serializerService;

    public function __construct(serializerService $serializer)
    {
        $this->serializerService = $serializer;
    }

    /**
     * @Route("/classe", name="classe", methods={"GET"})
     * @param ClasseRepository $classeRepository
     * @return Response
     */
    public function index(ClasseRepository $classeRepository): Response
    {
        return JsonResponse::fromJsonString($this->serializerService->RelationSerializer($classeRepository->findAll(), 'json'));
    }

    /**
     * @Route("/classe/new", name="classe_new", methods={"POST"})
     * @param Request $request
     * @param EcoleRepository $ecoleRepository
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function newEleve(Request $request, EcoleRepository $ecoleRepository, EntityManagerInterface $em): Response
    {
        $data = json_decode($request->getContent(), true);

        $randNumber = rand(10, 12);

        $ecole = $ecoleRepository->findOneBy(['id' => $randNumber]);

        $classe = new Classe();

        $classe->setNom($data['nom']);
        $classe->setEcole($ecole);

        $em->persist($classe);

        $em->flush();

        return new JsonResponse("Classe ajoute", Response::HTTP_OK);
    }
}
