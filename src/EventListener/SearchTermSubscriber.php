<?php

namespace App\EventListener;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class SearchTermSubscriber implements EventSubscriberInterface
{
    /**
     * @param RequestEvent $requestEvent
     * @return bool
     *
     * Ensures any spaces are replaced with a '-'
     */
    public function onKernelRequest(RequestEvent $requestEvent): bool
    {
        $searchTerm = $requestEvent->getRequest()->get('name');
        if (!empty($searchTerm)) {
            // PokeApi expects lower case
            $searchTerm     = strtolower($searchTerm);
            $searchTermSlug = $this->removeSpacesFromSearchTerm($searchTerm);
            $requestEvent->getRequest()->attributes->set('name', $searchTermSlug);
        }

        return true;
    }

    public static function getSubscribedEvents(): array
    {
        return [RequestEvent::class => 'onKernelRequest'];
    }

    private function removeSpacesFromSearchTerm(string $searchTerm): array|string
    {
        return str_replace(" ", "-", $searchTerm);
    }
}
