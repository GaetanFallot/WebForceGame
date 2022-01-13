<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
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

    #[Route('delete/user', name: 'delete_user')]
    public function getUsersList(UserRepository $UserRepository): Response
    {
        $users = $UserRepository->findAll();
        return $this->render('delete_user/index.html.twig', [
            'users' => $users
            ]
        );


    }

}
