<?php

namespace Bundle\AdminBundle\Manager;

use Doctrine\ORM\EntityManager;

class AdminManager
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getAdministrators()
    {
        $repository = $this->em->getRepository('Entity\User');
		$admins = $repository->findAdminUser();

        return $admins;
    }
}
