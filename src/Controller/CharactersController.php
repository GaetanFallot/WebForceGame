<?php

namespace App\Controller;

use App\Entity\Characters;
use App\Form\CharactersType;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Unique;

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
    public function create(
        Request $request, 
        EntityManagerInterface $manager,
        FileUploader $fileUploader
        ): Response
    {
        $characters = new Characters();
        $form = $this->createForm( CharactersType::class, $characters);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            if($file = $form->get('image')->getData()){
                $fileUploader->upload($characters, $file);
            }
            
            $manager -> persist($characters);
            $manager->flush();
        }

        return $this->render('characters/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
