<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/book')]
class BookController extends AbstractController
{
    #[Route('', name: 'app_book_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    #[Route(
        '/{id}',
        name: 'app_book_show',
        requirements: ['id' => '\d+'],
        defaults: ['id' => 0],
        methods: ['GET'],
    )]
    public function show(int $id = 1): Response
    {
        return $this->render('book/show.html.twig', [
            'controller_name' => 'BookController - id = '.$id,
        ]);
    }
}
