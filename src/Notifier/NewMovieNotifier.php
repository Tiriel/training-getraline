<?php

namespace App\Notifier;

use App\Entity\Movie;
use App\Entity\User;
use App\Notifier\Factory\NotificationFactoryInterface;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;
use Symfony\Component\Notifier\ChatterInterface;

class NewMovieNotifier
{
    public function __construct(
        protected readonly ChatterInterface $notifier,
        /** @var NotificationFactoryInterface[] $factories */
        #[TaggedIterator('app.notification_factory', defaultIndexMethod: 'getIndex')]
        protected iterable $factories,
    )
    {
        $this->factories = $factories instanceof \Traversable ? iterator_to_array($factories) : $factories;
    }

    public function send(User $user, Movie $movie): void
    {
        $message = sprintf('New movie dropped : "%s"', $movie->getTitle());

        $notification = $this->factories[$user->getChannel()]
            ->createNotification($user->getEmail(), $message);

        $this->notifier->send($notification);
    }
}
