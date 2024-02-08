<?php

namespace App\EventSubscriber;

use App\Service\EntityManagerSelectorService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class SubdomainListenerSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly RequestStack $requestStack,
//        private readonly EntityManagerSelectorService $emSelector,
    )
    {
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $host = $request->getHost();
        $subdomain = explode('.', $host)[0];

        $this->requestStack->getSession()->set('subdomain', $subdomain);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }
}
