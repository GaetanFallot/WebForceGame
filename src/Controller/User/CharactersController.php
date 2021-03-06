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

            return $this->redirectToRoute('user_characters'); 
        }

        return $this->render('characters/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/mes-personnages', name: 'user_characters')]
    public function getUserCharacters(
        CharactersRepository $charactersRepository,
        UserRepository $userRepository
    ): Response 
    {
  
        return $this->render('characters/user/user_characters.html.twig');
    }
}
