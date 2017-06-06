<?php

namespace Manager;

abstract class DefaultManager
{
    protected $em;
    protected $session;
    protected $entity_namespace;

    public function get($id)
    {
        $repository = $this->em->getRepository($this->entity_namespace);
		$entity = $repository->findOneById($id);

        return $entity;
    }

    public function getAll($orderBy = array())
    {
        $repository = $this->em->getRepository($this->entity_namespace);
		$entities = $repository->findBy(array(), $orderBy);

        return $entities;
    }

    public function save($entity)
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
        $repository = $this->em->getRepository($this->entity_namespace);
		$entity = $repository->findOneById($id);

        $this->em->remove($entity);
        $this->em->flush();

        $this->session->getFlashBag()->add(
            'success',
            'Suppression réussie'
        );
    }
}
