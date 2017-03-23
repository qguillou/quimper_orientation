<?php

namespace Bundle\HomeBundle\Controller;

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
use Bundle\HomeBundle\Manager\UserManager;

class RegisterController extends Controller
{
    public function registerAction(Request $request)
    {
      $user = new User();

      $form = $this->createForm(RegisterType::class, $user);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
          if ($this->get('manager.user')->register($user)){
            $token = new UsernamePasswordToken($user, $user->getPassword(), "public", array('ROLE_USER'));
            $this->get("security.token_storage")->setToken($token);
            $event = new InteractiveLoginEvent($request, $token);
            $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);

            return $this->redirectToRoute('home');
          }
      }

      return $this->render('HomeBundle:Authentification:register.html.twig',
        array('form_user' => $form->createView()));
    }
}
