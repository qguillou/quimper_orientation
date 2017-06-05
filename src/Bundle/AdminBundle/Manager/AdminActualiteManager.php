<?php

namespace Bundle\AdminBundle\Manager;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;
use Entity\Actualite;

class AdminActualiteManager
{
    protected $em;
    protected $session;

    public function __construct(EntityManager $em, Session $session)
    {
        $this->em = $em;
        $this->session = $session;
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
		$actualites = $repository->findBy(array(), array('dateModification' => 'DESC'));

        return $actualites;
    }

    public function save(Actualite $actualite)
    {
        $this->em->persist($actualite);
        $this->em->flush();

        $this->session->getFlashBag()->add(
          'success',
          'Édition réussie'
        );
    }

    public function delete($id)
    {
        $repository = $this->em->getRepository('Entity\Actualite');
		$actualite = $repository->findOneById($id);

        $this->em->remove($actualite);
        $this->em->flush();

        $this->session->getFlashBag()->add(
            'success',
            'Suppression réussie'
        );
    }
}
