<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/movie')]
class MovieController extends AbstractController
{
    #[Route('', name: 'app_movie_index', methods: ['GET'])]
    public function index(MovieRepository $repository, Request $request): Response
    {
        $limit = 9;
        $page = $request->query->getInt('page', 1);
        $movies = $repository->findBy([], [], $limit, ($page - 1) * $limit);

        return $this->render('movie/index.html.twig', [
            'movies' => $movies,
        ]);
    }

    #[Route('/{id}', name: 'app_movie_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(?Movie $movie): Response
    {
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
