<?php

namespace Manager;

use Manager\DefaultManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;

class ContactManager extends DefaultManager
{
    public function __construct(EntityManager $em, Session $session)
    {
        $this->em = $em;
        $this->session = $session;
        $this->entity_namespace = 'Entity\Contact';
    }
}
