<?php

namespace App\Controller\User;

use App\Entity\Characters;
use App\Form\CharactersType;
use App\Repository\CharactersRepository;
use App\Repository\UserRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CharactersController extends AbstractController
{

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
            $characters->setUser($this->getUser());
            $characters->setHp($characters->getHpMax());
            $manager -> persist($characters);
            $manager->flush();

            // return $this->redirectToRoute()  à mettre sur la route de ou sera stocké son personnage
        }

        return $this->render('characters/user_characters.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/mes-personnages', name: 'user_characters')]
    public function getUserCharacters(
        CharactersRepository $charactersRepository,
        UserRepository $userRepository
    ): Response 
    {
   
        
        // Condition pour afficher dans user_characters un message si jamais le user n'a pas de personnages
        // $user = $this->getUser();
        // $characters = $user->getCharacters()->toArray();
            
        return $this->render('characters/user/user_characters.html.twig'
        // , [
        //     'characters' => $characters
        // ]
    );
    }
}
