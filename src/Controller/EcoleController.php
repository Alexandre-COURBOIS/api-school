<?php

namespace App\Controller;

use App\Entity\Ecole;
use App\Form\EcoleType;
use App\Repository\EcoleRepository;
use App\Service\SerializerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;



class EcoleController extends AbstractController
{
    private SerializerService $serializerService;
    private EntityManagerInterface $em;

    public function __construct(serializerService $serializer, EntityManagerInterface $entityManager)
    {
        $this->serializerService = $serializer;
        $this->em = $entityManager;
    }

    /**
     * @Route("/ecole", name="ecole", methods={"GET"})
     * @param EcoleRepository $ecoleRepository
     * @return Response
     */
    public function index(EcoleRepository $ecoleRepository): Response
    {
        return JsonResponse::fromJsonString($this->serializerService->RelationSerializer($ecoleRepository->findAll(), 'json'));
    }

    /**
     * @Route("/ecole/new", name="ecole_new", methods={"POST"})
     * @param Request $request
     * @param ValidatorInterface $validator
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function newEcole(Request $request, ValidatorInterface $validator, EntityManagerInterface $em): Response
    {
        $data = json_decode($request->getContent(), true);

        if ($data) {

            if ($data['nom'] && $data['adresse']) {

                $ecole = new Ecole();

                $form = $this->createForm(EcoleType::class, $ecole);

                $form->submit($data);

                $validate = $validator->validate($ecole,null,'RegisterEcole');

                if(count($validate) !== 0) {
                    foreach ($validate as $error) {
                        return new JsonResponse($error->getMessage(), Response::HTTP_BAD_REQUEST);
                    }
                }

                $ecole->setCreatedAt(new \DateTime());

                $this->em->persist($ecole);

                $this->em->flush();

                return new JsonResponse("Ecole ajoute", Response::HTTP_CREATED);

            } else {
                return new JsonResponse("Merci de renseigner les champs correctement", RESPONSE::HTTP_NO_CONTENT);
            }
        } else {
            return new JsonResponse("Merci de renseigner les champs correctement", RESPONSE::HTTP_NO_CONTENT);
        }
    }

    /**
     * @Route("/ecole/delete/{id}", name="ecole_delete", methods={"DELETE"})
     * @param EcoleRepository $ecoleRepository
     * @param int $id
     * @return Response
     */
    public function deleteEcole(EcoleRepository $ecoleRepository, $id = 0): Response
    {
        $ecole = $ecoleRepository->find($id);


        if ($ecole) {

            $this->em->remove($ecole);
            $this->em->flush();

            return new JsonResponse("Ecole supprime", Response::HTTP_OK);
        } else {
            return new JsonResponse("Rien a supprimer", Response::HTTP_BAD_REQUEST);
        }
    }
}
