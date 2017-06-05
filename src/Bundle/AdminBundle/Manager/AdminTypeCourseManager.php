<?php

namespace Bundle\AdminBundle\Manager;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;
use Entity\Type;

class AdminTypeCourseManager
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
        $repository = $this->em->getRepository('Entity\Type');
		$type = $repository->findOneById($id);

        return $type;
    }

    public function getAll()
    {
        $repository = $this->em->getRepository('Entity\Type');
		$types = $repository->findBy(array(), array('nom' => 'ASC'));

        return $types;
    }

    public function save(Type $type)
    {
        $this->em->persist($type);
        $this->em->flush();

        $this->session->getFlashBag()->add(
          'success',
          'Édition réussie'
        );
    }

    public function delete($id)
    {
        $repository = $this->em->getRepository('Entity\Type');
		$type = $repository->findOneById($id);

        $this->em->remove($type);
        $this->em->flush();

        $this->session->getFlashBag()->add(
            'success',
            'Suppression réussie'
        );
    }
}
