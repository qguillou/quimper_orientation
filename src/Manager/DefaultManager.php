<?php

namespace Manager;


use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

abstract class DefaultManager
{
    protected $em;
    protected $session;
    protected $token;
    protected $password_encoder;
    protected $authorization_checker;
    protected $entity_namespace;

    public function __construct(EntityManager $em, Session $session, TokenStorage $token)
    {
        $this->em = $em;
        $this->session = $session;
        $this->token = $token;
    }

    public function setEntityNamespace($entity_namespace)
    {
        $this->entity_namespace = $entity_namespace;
    }

    public function setPasswordEncoder(UserPasswordEncoder $password_encoder)
    {
        $this->password_encoder = $password_encoder;
    }

    public function get($id)
    {
        $repository = $this->em->getRepository($this->entity_namespace);
		$entity = $repository->findOneById($id);

        if (!$entity) {
            $entity = $this->create();
            $entity->setDateCreation(new \DateTime('now'));
            $entity->setUserCreation($this->token->getToken()->getUser());
        }

        $entity->setDateModification(new \DateTime('now'));
        $entity->setUserModification($this->token->getToken()->getUser());

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
