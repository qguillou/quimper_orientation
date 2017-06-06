<?php

namespace Bundle\AdminBundle\Manager;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;
use Entity\Role;

class AdminRoleManager
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
        $repository = $this->em->getRepository('Entity\Role');
		$role = $repository->findOneById($id);

        return $role;
    }

    public function getAll()
    {
        $repository = $this->em->getRepository('Entity\Role');
		$roles = $repository->findAll();

        return $roles;
    }

    public function save(Role $role)
    {
        $this->em->persist($role);
        $this->em->flush();

        $this->session->getFlashBag()->add(
          'success',
          'Édition réussie'
        );
    }

    public function delete($id)
    {
        $repository = $this->em->getRepository('Entity\Role');
		$role = $repository->findOneById($id);

        $this->em->remove($role);
        $this->em->flush();

        $this->session->getFlashBag()->add(
            'success',
            'Suppression réussie'
        );
    }
}
