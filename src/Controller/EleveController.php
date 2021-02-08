<?php

namespace App\Controller;

use App\Entity\Eleve;
use App\Repository\ClasseRepository;
use App\Repository\EleveRepository;
use App\Service\SerializerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
        return JsonResponse::fromJsonString($this->serializerService->RelationSerializer($eleveRepository->findAll(),'json'));
    }

    /**
     * @Route("/eleve/new", name="eleve_new", methods={"POST"})
     * @param ClasseRepository $classeRepository
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function newEleve(ClasseRepository $classeRepository,Request $request, EntityManagerInterface $em): Response
    {
        $data = json_decode($request->getContent(), true);

        $classe = $classeRepository->findOneBy(['id' => 7]);

        $eleve = new Eleve();

        $eleve->setNom($data['nom']);
        $eleve->setPrenom($data['prenom']);
        $eleve->setAge($data['age']);
        $eleve->setClasse($classe);
        $eleve->setCreatedAt(new \DateTime());

        $em->persist($eleve);

        $em->flush();

        return new JsonResponse("Eleve ajoute", Response::HTTP_OK);
    }
}
