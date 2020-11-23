<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class RequestLocaleListener implements EventSubscriberInterface
{

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();

        if ($request->query->get('_locale')) {
            $request->setLocale($request->query->get('_locale'));
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }
}