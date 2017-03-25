<?php

namespace Bundle\HomeBundle\Manager;

use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Entity\User;

class UserManager
{
    protected $em;
    protected $encoder;
    protected $security;

    public function __construct(EntityManager $em,
                                UserPasswordEncoder $encoder,
                                $security)
    {
        $this->em = $em;
        $this->encoder = $encoder;
        $this->security = $security;
    }

    public function register(User $user)
    {
      $password = $this->encoder->encodePassword($user, $user->getPlainPassword());
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

      if($u && ($this->encoder->isPasswordValid($u ,$user->getPlainPassword(),$u->getSalt()))){
        return $u;
      }

      return null;
    }
}
