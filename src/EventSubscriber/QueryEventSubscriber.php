<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use PiWeb\PiCRUD\Event\QueryEvent;
use PiWeb\PiCRUD\Event\PiCrudEvents;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class QueryEventSubscriber implements EventSubscriberInterface
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function postListQueryBuilder(QueryEvent $event)
    {
        $queryBuilder = $event->getQueryBuilder();

        switch ($event->getType()) {
            case 'event':
                break;
            default:
                $queryBuilder->orderBy('entity.updateAt', 'DESC');
        }
    }

    public function postAdminQueryBuilder(QueryEvent $event)
    {
        $queryBuilder = $event->getQueryBuilder();

        $queryBuilder->orderBy('entity.updateAt', 'DESC');
    }

    public static function getSubscribedEvents()
    {
        return [
            PiCrudEvents::POST_LIST_QUERY_BUILDER => ['postListQueryBuilder'],
            PiCrudEvents::POST_ADMIN_QUERY_BUILDER => ['postAdminQueryBuilder']
        ];
    }
}
