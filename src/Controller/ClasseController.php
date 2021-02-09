<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Entity\Ecole;
use App\Form\ClasseType;
use App\Repository\ClasseRepository;
use App\Repository\EcoleRepository;
use App\Service\SerializerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ClasseController extends AbstractController
{

    private SerializerService $serializerService;
    private EntityManagerInterface $em;

    public function __construct(serializerService $serializer, EntityManagerInterface $entityManager)
    {
        $this->serializerService = $serializer;
        $this->em = $entityManager;
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
     * @param ValidatorInterface $validator
     * @return Response
     */
    public function newClasse(Request $request, EcoleRepository $ecoleRepository, EntityManagerInterface $em, ValidatorInterface $validator): Response
    {
        $data = json_decode($request->getContent(), true);

        if ($data) {

            $randNumber = rand(10, 12);

            $ecole = $ecoleRepository->findOneBy(['id' => $randNumber]);

            if ($data['nom']) {

                $classe = new Classe();

                $form = $this->createForm(ClasseType::class, $ecole);

                $form->submit($data);

                $validate = $validator->validate($classe, null, 'RegisterClasse');

                if (count($validate) !== 0) {
                    foreach ($validate as $error) {
                        return new JsonResponse($error->getMessage(), Response::HTTP_BAD_REQUEST);
                    }
                }

                $classe->setEcole($ecole);

                $this->em->persist($classe);

                $this->em->flush();

                return new JsonResponse("Classe ajoute", Response::HTTP_CREATED);

            } else {
                return new JsonResponse("Merci de renseigner les champs correctement", RESPONSE::HTTP_NO_CONTENT);
            }
        } else {
            return new JsonResponse("Merci de renseigner les champs correctement", RESPONSE::HTTP_NO_CONTENT);
        }
    }
}
