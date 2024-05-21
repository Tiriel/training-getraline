<?php

namespace App\Controller;

use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/song', name: 'app_song_index', methods: ['GET'])]
#[Template('book/index.html.twig')]
class SongController
{
    public function __invoke(): array
    {
        return ['controller_name' => 'SongController'];
    }
}
