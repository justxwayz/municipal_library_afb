<?php

namespace App\Controller\Admin;

use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
class DefaultController extends AbstractController
{
    #[Route('/', name: 'admin_index')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');

        return $this->render('admin/default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    #[Route('/dashboard', name: 'admin_dashboard')]
    public function dashboard(
        UserRepository $userRepository,
        BookRepository $bookRepository,
        AuthorRepository $authorRepository
    ): Response {
        $usersCount = $userRepository->count([]);
        $booksCount = $bookRepository->count([]);
        $authorsCount = $authorRepository->count([]);

        return $this->render('admin/default/dashboard.html.twig', [
            'usersCount' => $usersCount,
            'booksCount' => $booksCount,
            'authorsCount' => $authorsCount,
        ]);
    }

    #[Route('/settings', name: 'admin_settings')]
    public function settings(): Response
    {
        $user = $this->getUser();

        return $this->render('admin/default/settings.html.twig', [
            'user' => $user,
        ]);
    }
}
