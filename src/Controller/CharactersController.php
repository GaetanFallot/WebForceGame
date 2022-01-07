<?php

namespace App\Controller;

use App\Entity\Characters;
use App\Form\CharactersType;
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

    #[Route('/createCharacters', name: 'createCharacters')]
    public function create()
    {
        $characters = new Characters();
        $form = $this->createForm( CharactersType::class, $characters);

        return $this->render('characters/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
