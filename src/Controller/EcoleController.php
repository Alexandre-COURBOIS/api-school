<?php

namespace App\Controller;

use App\Repository\EcoleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EcoleController extends AbstractController
{
    /**
     * @Route("/ecole", name="ecole", methods={"GET"})
     * @param EcoleRepository $ecoleRepository
     * @return Response
     */
    public function index(EcoleRepository $ecoleRepository): Response
    {
        $ecole = $ecoleRepository->findAll();

        return new JsonResponse(["ecoles" => $ecole]);
    }
}
