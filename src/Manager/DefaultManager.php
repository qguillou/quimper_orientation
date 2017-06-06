<?php

namespace Manager;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;

abstract class DefaultManager
{
    abstract protected $entity_namespace;
    protected $em;
    protected $session;

    public function __construct(EntityManager $em, Session $session)
    {
        $this->em = $em;
        $this->session = $session;
    }

    public function get($id)
    {
        $repository = $this->em->getRepository($entity_namespace);
		$entity = $repository->findOneById($id);

        return $entity;
    }

    public function getAll($orderBy = array())
    {
        $repository = $this->em->getRepository($entity_namespace);
		$entities = $repository->findBy(array(), $orderBy);

        return $entities;
    }

    public function save(DefaultEntity $entity)
    {
        $this->em->persist($entity);
        $this->em->flush();

        $this->session->getFlashBag()->add(
          'success',
          'Édition réussie'
        );
    }

    public function delete($id)
    {
        $repository = $this->em->getRepository($entity_namespace);
		$entity = $repository->findOneById($id);

        $this->em->remove($entity);
        $this->em->flush();

        $this->session->getFlashBag()->add(
            'success',
            'Suppression réussie'
        );
    }
}
