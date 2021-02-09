<?php

namespace App\Controller;

use App\Entity\Eleve;
use App\Form\EleveType;
use App\Repository\ClasseRepository;
use App\Repository\EleveRepository;
use App\Service\SerializerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EleveController extends AbstractController
{
    private SerializerService $serializerService;
    private EntityManagerInterface $em;

    public function __construct(serializerService $serializer, EntityManagerInterface $entityManager)
    {
        $this->serializerService = $serializer;
        $this->em = $entityManager;
    }

    /**
     * @Route("/eleve", name="eleve", methods={"GET"})
     * @param EleveRepository $eleveRepository
     * @return Response
     */
    public function index(EleveRepository $eleveRepository): Response
    {
        return JsonResponse::fromJsonString($this->serializerService->RelationSerializer($eleveRepository->findAll(), 'json'));
    }

    /**
     * @Route("/eleve/new", name="eleve_new", methods={"POST"})
     * @param ClasseRepository $classeRepository
     * @param ValidatorInterface $validator
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function newEleve(ClasseRepository $classeRepository, ValidatorInterface $validator, Request $request, EntityManagerInterface $em): Response
    {
        $data = json_decode($request->getContent(), true);

        if ($data) {

            $classe = $classeRepository->findOneBy(['id' => 7]);

            if ($data['nom'] && $data['prenom'] && $data['age']) {

                $eleve = new Eleve();

                $form = $this->createForm(EleveType::class, $eleve);

                $form->submit($data);

                $validate = $validator->validate($eleve,null,'RegisterEleve');

                if(count($validate) !== 0) {
                    foreach ($validate as $error) {
                        return new JsonResponse($error->getMessage(), Response::HTTP_BAD_REQUEST);
                    }
                }

                $eleve->setClasse($classe);
                $eleve->setCreatedAt(new \DateTime());

                $this->em->persist($eleve);

                $this->em->flush();

                return new JsonResponse("Eleve ajoute", Response::HTTP_CREATED);

            } else {
                return new JsonResponse("Merci de renseigner les champs correctement", RESPONSE::HTTP_NO_CONTENT);
            }
        } else {
            return new JsonResponse("Merci de renseigner des informations valide", RESPONSE::HTTP_NO_CONTENT);
        }
    }
}
