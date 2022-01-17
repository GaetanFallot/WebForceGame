<?php

namespace App\Controller;

use App\Repository\ProfessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ProfessionController extends AbstractController
{
    #[Route('/profession/getDetails/{idProfession}', name: 'app_get_profession_details')]
    public function getDetails($idProfession, ProfessionRepository $professionRepository): Response
    {
        $profession = $professionRepository->find($idProfession);

        return new JsonResponse([
            'description' => $profession->getDescription(),
            'image' =>$profession->getImageSrc(),
        ]);
    }

    
}
