<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashBoardController extends AbstractController
{
    #[Route('/dashboard', name: 'admin_dashboard')]
    public function index(): Response
    {
        return $this->render('admin/dashboard/index.html.twig', [
            'controller_name' => 'DashBoardController',
        ]);
    }

    #[Route('/moderation', name: 'moderation')]
    public function getUsersList(UserRepository $UserRepository): Response
    {
        $users = $UserRepository->findAll();
        return $this->render('moderation/index.html.twig', [
            'users' => $users
            ]
        );
    }
    #[Route('/viewprofil/{id}', name: 'viewprofil')]
    public function getProfil( User $user): Response
    {


        return $this->render('admin/dashboard/viewprofil/index.html.twig', [
                'user' => $user
            ]
        );
    }

    #[Route('/supprimer/{id}', name: 'deleteprofil')]
    public function delete(EntityManagerInterface $entityManager, User $user): Response
    {
        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash('message', 'Utilisateur supprimé avec succès');
        return $this->render('admin/dashboard/viewprofil/index.html.twig');

    }
    #[Route('/bloquer/{id}', name: 'bloquerprofil')]
    public function bloquer(EntityManagerInterface $entityManager, User $user): Response
    {
        $user->setIsBanned("true");
        $entityManager->flush();


        $this->addFlash('message', 'Utilisateur bloqué avec succès');
        return $this->render('admin/dashboard/succesbloque.html.twig', [
            'user' => $user
        ]);

    }
    #[Route('/debloquer/{id}', name: 'debloquerprofil')]
    public function debloquer(EntityManagerInterface $entityManager, User $user): Response
    {
        $user->setIsBanned("false");
        $entityManager->flush();


        $this->addFlash('message', 'Utilisateur débloqué avec succès');
        return $this->render('admin/dashboard/succesdebloque.html.twig', [
            'user' => $user
    ]);

    }



}
