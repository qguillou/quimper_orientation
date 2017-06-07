<?php

namespace Bundle\HomeBundle\Controller;

use Bundle\HomeBundle\Form\User\RegisterType;
use Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken,
Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class RegisterController extends Controller
{
    public function registerAction(Request $request)
    {
      $user = new User();
      $dispatcher = new EventDispatcher();

      $form = $this->createForm(RegisterType::class, $user);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
          if ($this->get('manager.user')->register($user)){
            $token = new UsernamePasswordToken($user, $user->getPassword(), "public", array('ROLE_USER'));
            $this->get("security.token_storage")->setToken($token);
            $event = new InteractiveLoginEvent($request, $token);
            $dispatcher->dispatch("security.interactive_login", $event);

            return $this->redirectToRoute('home');
          }
      }

      return $this->render('HomeBundle:Authentification:register.html.twig',
        array('form_user' => $form->createView()));
    }
}
