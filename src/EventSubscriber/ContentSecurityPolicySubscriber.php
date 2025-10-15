<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ContentSecurityPolicySubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => 'onResponse',
        ];
    }

    public function onResponse(ResponseEvent $event): void
    {
        $response = $event->getResponse();

        $csp = "default-src 'self'; ";
        $csp .= "script-src 'self' https://trusted.cdn.com; ";
        $csp .= "img-src 'self'; ";
        $csp .= "style-src 'self'; ";
        $csp .= "font-src 'self';";

        $response->headers->set('Content-Security-Policy', $csp);
    }
}
