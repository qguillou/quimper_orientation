<?php

namespace Bundle\AdminBundle\Manager;

use Doctrine\ORM\EntityManager;
use Entity\Actualite;

class AdminActualiteManager
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function get($id)
    {
        $repository = $this->em->getRepository('Entity\Actualite');
		$actualite = $repository->findOneById($id);

        return $actualite;
    }

    public function getAll()
    {
        $repository = $this->em->getRepository('Entity\Actualite');
		$actualites = $repository->findAll();

        return $actualites;
    }

    public function save(Actualite $actualite)
    {
        $this->em->persist($actualite);
        $this->em->flush();
    }

    public function delete($id)
    {
        $repository = $this->em->getRepository('Entity\Actualite');
		$actualite = $repository->findOneById($id);

        $this->em->remove($actualite);
        $this->em->flush();
    }
}
