<?php

namespace AppBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LastRouteListener implements EventSubscriberInterface
{
    public function onKernelRequest(GetResponseEvent $event)
    {
        // Do not save subrequests
        if (!$event->isMasterRequest()) {
            return;
        }

        $request = $event->getRequest();
        $session = $request->getSession();

        $routeName = $request->get('_route');
        $routeParams = $request->get('_route_params');

        if ($routeName[0] == '_') {
            return;
        }

        $routeData = ['name' => $routeName, 'params' => $routeParams];

        $thisRoute = $session->get('this_route', []);

        // Do not save the same matched route twice
        if ($thisRoute == $routeData) {
            return;
        }

        $session->set('last_route', $thisRoute);
        $session->set('this_route', $routeData);
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => [['onKernelRequest', 30]],
        ];
    }
}