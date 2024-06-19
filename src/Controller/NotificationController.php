<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\User;
use App\Notifier\NewMovieNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class NotificationController extends AbstractController
{
    #[Route('/notification/{id}', name: 'app_notification', requirements: ['id' => '\d+'])]
    public function index(NewMovieNotifier $notifier, Movie $movie): JsonResponse
    {
        $user = (new User())
            ->setEmail('admin@admin.com')
            ->setChannel('slack');
        $notifier->send($user, $movie);

        return $this->json([
            'message' => 'Notification sent',
        ]);
    }
}
