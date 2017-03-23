<?php

namespace Bundle\ClubBundle\Manager;

use Doctrine\ORM\EntityManager;
use Entity\Contact;

class ContactManager
{
    protected $em;

    public function __construct(EntityManager $em)
    {
      $this->em = $em;
    }

    public function getContact()
    {
      $repository = $this->em->getRepository('Entity\Contact');

      return $repository->findContact();
    }
}
