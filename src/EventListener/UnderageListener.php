<?php

namespace App\EventListener;

use App\Event\MovieUnderageEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Part\TextPart;

final class UnderageListener
{
    public function __construct(protected readonly MailerInterface $mailer)
    {
    }

    #[AsEventListener(event: MovieUnderageEvent::class)]
    public function onMovieUnderageEvent(MovieUnderageEvent $event): void
    {
        $user = $event->getUser();
        $movie = $event->getMovie();
        $message = sprintf('User "%s" tried to view movie "%s" - rated %s, age %d',
            $user->getUserIdentifier(),
            $movie->getTitle(),
            $movie->getRated(),
            $user->getAge(),
        );

        $this->mailer->send((new Email(null, new TextPart($message))));
    }
}
