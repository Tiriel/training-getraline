<?php

namespace App\EventListener;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

final class RequestListener
{
    public const ROUTES = [
        'app_book_',
    ];

    public function __construct(
        protected readonly Environment $twig,
        #[Autowire('%env(bool:APP_DISABLED)%')]
        protected readonly bool $isDisabled,
    )
    {
    }

    #[AsEventListener(event: RequestEvent::class, priority: 0)]
    public function onKernelRequest(RequestEvent $event): void
    {
        if ($event->isMainRequest() && $this->isDisabled) {
            foreach (self::ROUTES as $route) {
                $routeName = $event->getRequest()->attributes->get('_route');
                if (str_starts_with($routeName, $route)) {
                    $event->setResponse(
                        new Response($this->twig->render('deactivation.html.twig'))
                    );
                }

                return;
            }
        }
    }
}
