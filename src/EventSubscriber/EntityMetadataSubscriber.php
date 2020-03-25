<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\EventDispatcher\GenericEvent;

class EntityMetadataSubscriber implements EventSubscriberInterface
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function onEntityPrePersist(GenericEvent $event)
    {
        $entity = $event->getSubject();
        
        $entity->setCreateBy($this->security->getUser());
        $entity->setUpdateBy($this->security->getUser());
    }

    public function onEntityPreUpdate(GenericEvent $event)
    {
        $entity = $event->getSubject();
        $entity->setUpdateBy($this->security->getUser());
    }

    public static function getSubscribedEvents()
    {
        return [
            'app.entity.pre_persist' => 'onEntityPrePersist',
            'app.entity.pre_update' => 'onEntityPreUpdate',
        ];
    }
}
