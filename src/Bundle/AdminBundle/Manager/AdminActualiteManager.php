<?php

namespace Bundle\AdminBundle\Manager;

use Doctrine\ORM\EntityManager;

class AdminActualiteManager
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getAll()
    {
        $repository = $this->em->getRepository('Entity\Actualite');
		$actualites = $repository->findAll();

        return $actualites;
    }

    public function delete($id)
    {
        $repository = $this->em->getRepository('Entity\Actualite');
		$actualite = $repository->findOneById($id);

        $this->em->remove($actualite);
        $this->em->flush();
    }
}
