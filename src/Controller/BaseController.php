<?php

namespace App\Controller;

use App\Repository\ProfessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    #[Route('', name: 'home')]
    public function index(ProfessionRepository $professionRepository): Response
    {
        $professions = $professionRepository->findAll();

        return $this->render('base/index.html.twig', [
            'professions' => $professions,
        ]);
    }

    
}
