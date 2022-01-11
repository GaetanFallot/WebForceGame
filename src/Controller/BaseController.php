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
        $profession = $professionRepository->find(2);

        return $this->render('base/index.html.twig', [
            'profession' => $profession,
        ]);
    }

    
}
