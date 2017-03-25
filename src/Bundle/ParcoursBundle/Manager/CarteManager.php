<?php

namespace Bundle\ParcoursBundle\Manager;

use Doctrine\ORM\EntityManager;

class CarteManager
{
    protected $em;

    public function __construct(EntityManager $em)
    {
      $this->em = $em;
    }

    public function getCarte()
    {
      $repository = $this->em->getRepository('Entity\Cartes');

      return $repository->findAll();
    }
}
