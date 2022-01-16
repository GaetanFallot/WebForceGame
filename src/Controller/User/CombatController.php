<?php

namespace App\Controller\User;

use App\Entity\Characters;
use App\Entity\Combat;
use App\Entity\Hit;
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

    #[Route('/mes-combats-accepted/{id}', name: 'user_combat_start')]
    public function combatAccepte(
        EntityManagerInterface $manager,
        Combat $combat
    ): Response
    {
        $combat->setStatus('in progress');
        $manager->flush();

        return $this->redirectToRoute('user_combat_list');
        // return $this->redirectToRoute('fight');
        // return $this->render('user/combat/fight.html.twig');
    }

    #[Route('/mes-combats-refuse/{id}', name: 'user_combat_refused')]
    public function combatRefused(
        EntityManagerInterface $manager,
        Combat $combat
    ): Response
    {
        $combat->setStatus('refused');
        $manager->flush();

        return $this->redirectToRoute('user_combat_list');
    }

    #[Route('/fight/{id}', name: 'user_combat')]
    public function combatStart(
        EntityManagerInterface $manager,
        Combat $combat
    ): Response
    {
        // dd(json($data));
        // $challenger = $combat->getChallenger();
        // $outsider = $combat->getOpponent($challenger);
        // $challengerHp = $challenger->getHp();
        // $outsiderHp = $outsider->getHp();
        
        // if($challengerHp <= 0 )
        // {
        //     dd($challenger->getHp());
        // }
        
        return $this->render('user/combat/fight.html.twig', [
            'combat' => $combat
        ]);
    }

    #[Route('/fight/{id}/hit', name: 'user_combat_hit', methods: ['POST'])]
    public function combatHit(
        Combat $combat,
        EntityManagerInterface $entityManager,
        Request $request
    ): Response
    {
        $character = $combat->getCharacterByUser($this->getUser());

        if ($combat->getNextHitter() !== $character) {
            throw new \Exception("NOT YOUR TURN");
        }

        $type = $request->request->get('hit');
        $damage = $character->getHitTypeDamage($type);
        $opponent = $combat->getOpponent($character);
        $opponent = $opponent->decrementHp($damage);
        if ($opponent->getHp() <= 0 ) {
            $combat->setStatus(Combat::FIGHT_END);
            $combat->setVainqueur($character);
            $entityManager->flush();
            
            return $this->redirectToRoute('user_combat_list');
        }

        $hit = (new Hit())
            ->setCombat($combat)
            ->setCharacter($character)
            ->setType($type)
            ->setDamage($damage);
        $entityManager->persist($hit);
        $entityManager->flush();

        return new Response();
    }

    #[Route('/fight/{id}/data', name: 'user_combat_data')]
    public function combatData(Combat $combat): Response
    {
        $challenger = $combat->getChallenger();
        $outsider = $combat->getOpponent($challenger);

        $data = [
            'challenger' => [
                'hp' => $challenger->getHp(),
            ],
            'outsider' => [
                'hp' => $outsider->getHp(),
            ],
            'next' => $combat->getNextHitter() === $combat->getChallenger() ? 'challenger' : 'outsider',
            'status' => $combat->getStatus(),
        ];

        return $this->json($data);
    }


}
