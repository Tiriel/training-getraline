<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/movie')]
class MovieController extends AbstractController
{
    #[Route('', name: 'app_movie_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('movie/index.html.twig', [
            'controller_name' => 'MovieController',
        ]);
    }

    #[Route('/{id}', name: 'app_movie_show', methods: ['GET'])]
    public function show(int $id): Response
    {
        $movie = [
            'id' => $id,
            'title' => 'Star Wars - Episode IV : A New Hope',
            'country' => 'United States',
            'plot' => 'A young farmer breaks his fathers toys.',
            'releasedAt' => new \DateTimeImmutable('25-05-1977'),
            'genres' => ['Action', 'Adventure', 'Fantasy'],
        ];

        return $this->render('movie/show.html.twig', [
            'movie' => $movie,
        ]);
    }
}
