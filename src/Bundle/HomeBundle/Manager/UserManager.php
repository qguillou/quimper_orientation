<?php

namespace Bundle\HomeBundle\Manager;

use Doctrine\ORM\EntityManager;
use Bundle\HomeBundle\Form\User\RegisterType;
use Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken,
Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

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

    public function register($user)
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

    public function login($user)
    {
      $repository = $this->em->getRepository('Entity\User');
      $u = $repository->findOneBy(array('username' => $user->getUsername()));

      if($u && ($this->encoder->isPasswordValid($u ,$user->getPlainPassword(),$u->getSalt()))){
        return $u;
      }

      return null;
    }
}
