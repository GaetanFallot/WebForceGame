<?php

namespace App\Controller\User;

use App\Entity\Characters;
use App\Entity\Combat;
use App\Repository\CharactersRepository;
use App\Repository\CombatRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CombatController extends AbstractController
{
    // #[Route('/user/combat', name: 'user_combat')]
    // public function index(): Response
    // {
    //     return $this->render('user/combat/index.html.twig', [
    //         'controller_name' => 'CombatController',
    //     ]);
    // }
    
    #[Route('/cree-combats', name: 'user_combat_create', methods:['POST'])]
    public function createCombat(
        Request $request,
        CharactersRepository $charactersRepository,
        EntityManagerInterface $manager

    )
    {

        $combat = new Combat();
        $combat->setStatus('pending');
        
        $fighter1 = $request->request->get('character_id');
        $fighter2 = $request->request->get('combat_opponent');   
        
        $fighter1 = $charactersRepository->find($fighter1);
        $fighter2 = $charactersRepository->find($fighter2);
        
        
        $combat->setChallenger($fighter1);
        
        $combat->addCharacter($fighter1);    
        $combat->addCharacter($fighter2);  
        
        $combat->setDateCombat(new DateTimeImmutable());
        
        $manager -> persist($combat);
        $manager->flush();
        


        return $this->redirectToRoute('user_combat_list');
    }
    
    #[Route('/mes-combats', name: 'user_combat_list')]
    public function userCombatList(
        CombatRepository $combatRepository
    ): Response
    {
        $combats = $combatRepository->findUserCombats($this->getUser());

        return $this->render('user/combat/user_combat_list.html.twig'
        ,[
            'combats' => $combats
        ]
        );
    }

    
}
