<?php

namespace App\Controller;

use App\Entity\Characters;
use App\Form\CharactersType;
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
        EntityManagerInterface $manager
        ): Response
    {
        $characters = new Characters();
        $form = $this->createForm( CharactersType::class, $characters);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            if($file = $form->get('image')->getData()){
                $directory = $this->getParameter('public_path').Characters::IMAGE_DIRECTORY;
                $fileName = sprintf("%s-%s.%s", explode(".", $file->getClientOriginalName())[0] ?? "avatar", uniqid(), $file->guessClientExtension());
                $file->move($directory, $fileName);
                $characters->setImage($fileName);
            }

            $hp_max = $characters->getHpMax();
            $con = $characters->getCon();
            $hp_max = 3*$con+$hp_max;
            $characters->setHpMax($hp_max);

            $att_contact = $characters->getStr();
            $att_contact = $att_contact*3;
            $characters->setAttContact($att_contact);

            $att_distance = $characters->getDex();
            $att_distance = $att_distance*3;
            $characters->setAttDistance($att_distance);
            
            $att_magie = $characters->getIntel();
            $att_magie = $att_magie*3;
            $characters->setAttMagie($att_magie);

            $characters->setHp($hp_max);
            
            $manager -> persist($characters);
            $manager->flush();
        }

        return $this->render('characters/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
