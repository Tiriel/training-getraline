<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieType;
use App\Provider\MovieProvider;
use App\Repository\MovieRepository;
use App\Security\Voter\MovieUnderageVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\CacheItem;
use Symfony\Component\Clock\Clock;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\ValueResolver;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Contracts\Cache\CacheInterface;

#[Route('/movie')]
class MovieController extends AbstractController
{
    #[Route('', name: 'app_movie_index', methods: ['GET'])]
    public function index(MovieRepository $repository, Request $request, int $limit): Response
    {
        $page = $request->query->getInt('page', 1);
        $movies = $repository->findBy([], [], $limit, ($page - 1) * $limit);

        return $this->render('movie/index.html.twig', [
            'movies' => $movies,
        ]);
    }

    #[Route('/{id}', name: 'app_movie_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(
        int $id,
        MovieRepository $repository,
        Request $request,
        CacheInterface $cache,
        SluggerInterface $slugger
    ): Response {
        $key = $slugger->slug(Movie::class.'-'. $id);
        $lastUpdated = $cache->get($key, fn() => new \DateTimeImmutable());
        $response = (new Response())->setLastModified($lastUpdated);

        if ($response->isNotModified($request)) {
            return $response;
        }
        $movie = $repository->find($id);
        $this->denyAccessUnlessGranted(MovieUnderageVoter::UNDERAGE, $movie);

        return $this->render('movie/show.html.twig', [
            'movie' => $movie
        ], $response);
    }

    #[IsGranted(MovieUnderageVoter::UNDERAGE, 'movie')]
    #[Route('/omdb/{title}', name: 'app_movie_omdb', methods: ['GET'])]
    public function omdb(#[ValueResolver('movie_title')] ?Movie $movie): Response
    {
        return $this->render('movie/show.html.twig', [
            'movie' => $movie,
        ]);
    }

    #[Route('/new', name: 'app_movie_new', methods: ['GET', 'POST'])]
    #[Route('/{id}/edit', name: 'app_movie_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function new(?Movie $movie, Request $request, EntityManagerInterface $manager, CacheInterface $cache): Response
    {
        $movie ??= new Movie();
        $form = $this->createForm(MovieType::class, $movie);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $movie->setUpdatedAt(Clock::get()->now());
            $cache->get(Movie::class.$movie->getId(), function (CacheItem $item) use ($movie) {
                $item->expiresAfter(86400);
                // App\Entity\Movie1 => 22-05-2024 26:23:49
                return $movie->getUpdatedAt();
            });

            $manager->persist($movie);
            $manager->flush();

            return $this->redirectToRoute('app_movie_show', ['id' => $movie->getId()]);
        }

        return $this->render('movie/new.html.twig', [
            'form' => $form,
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
