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

    #[Route('/{id}', name: 'app_movie_show', requirements: ['id' => '\d+'], methods: ['GET'])]
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

    public function decades(): Response
    {
        $decades = [
            ['year' => 1970],
            ['year' => 1980],
            ['year' => 1990],
            ['year' => 2000],
        ];

        $response = new Response($this->render('includes/_decades.html.twig', [
            'decades' => $decades,
        ]));

        return $response;
    }
}
