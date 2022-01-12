<?php

namespace App\Controller;

use App\Repository\CharactersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CharactersController extends AbstractController
{
    #[Route('/characters', name: 'characters')]
    public function index(): Response
    {
        return $this->render('characters/index.html.twig', [
            'controller_name' => 'CharactersController',
        ]);
    }

    // ici faire characters liste

    #[Route('/charactersList', name: 'charactersList')]
    public function getCharactersList(
        CharactersRepository $charactersRepository
    ): Response 
    {
        $characters = $charactersRepository->findAll();
        
        return $this->render('base/charactersList.html.twig', [
            'characters' => $characters
        ]);
    }
}
