<?php

namespace Manager;

use Manager\DefaultManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;
use Form\Type\UserType;
use Entity\User;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class UserManager extends DefaultManager
{
    public function create()
    {
        $entity = new User();

        return $entity;
    }

    public function getFormClass()
    {
        return UserType::class;
    }

    public function getAdminPageTitle()
    {
        return "Administration des utilisateurs";
    }

    public function getDisplayColumnTitle()
    {
        return array(
            'Identifiant',
            'Nom',
            'Prénom',
            'E-mail'
        );
    }

    public function getDisplayColumn()
    {
        return array(
            'username',
            'nom',
            'prenom',
            'email'
        );
    }

    public function getDisplayFormField()
    {
        return array(
            'username',
            'nom',
            'prenom',
            'email',
            'license',
            'newsletter'
        );
    }

    public function getOrderBy()
    {
        return array('username' => 'ASC');
    }

    public function getWebmasters()
    {
        $repository = $this->em->getRepository($this->entity_namespace);
		$admins = $repository->findAdminUser();

        return $admins;
    }

    public function register(User $user)
    {
      $password = $this->password_encoder->encodePassword($user, $user->getPlainPassword());
      $user->setPassword($password);
      $user->setNewsletter(true);

      try {
        $this->em->persist($user);
        $this->em->flush();
      }
      catch (UniqueConstraintViolationException $e){
            return false;
      }

      return true;
    }

    public function login(User $user)
    {
      $repository = $this->em->getRepository('Entity\User');
      $u = $repository->findOneBy(array('username' => $user->getUsername()));

      if($u && ($this->password_encoder->isPasswordValid($u ,$user->getPlainPassword(),$u->getSalt()))){
        return $u;
      }

      return null;
    }
}
