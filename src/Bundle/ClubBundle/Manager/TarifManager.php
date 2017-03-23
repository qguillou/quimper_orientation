<?php

namespace Bundle\ClubBundle\Manager;

use Doctrine\ORM\EntityManager;
use Entity\Tarif;

class TarifManager
{
    protected $em;

    public function __construct(EntityManager $em)
    {
      $this->em = $em;
    }

    public function getTarif()
    {
      $repository = $this->em->getRepository('Entity\Tarif');

      return $repository->findAll();
    }
}
