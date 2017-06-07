<?php

namespace Bundle\HomeBundle\Controller;

use Bundle\HomeBundle\Form\User\LoginType;
use Bundle\HomeBundle\Form\User\ResetPasswordType;
use Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
 use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken,
Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class LoginController extends Controller
{
    public function loginAction(Request $request)
    {
      $user = new User();
      $dispatcher = new EventDispatcher();

      $form = $this->createForm(LoginType::class, $user);
      $form_password = $this->createForm(ResetPasswordType::class, $user);

      $form->handleRequest($request);
      if ($form->isSubmitted()) {
        if (($u = $this->get('manager.user')->login($user))) {
          $token = new UsernamePasswordToken($u, $u->getPassword(), "public", $u->getRoles());
          $this->get("security.token_storage")->setToken($token);
          $event = new InteractiveLoginEvent($request, $token);
          $dispatcher->dispatch("security.interactive_login", $event);

          $this->get('session')->getFlashBag()->add(
            'success',
            'Bonjour '.$u->getPrenom().',
            Vous êtes maintenant connecté sur le site de Quimper Orientation.
            Ceci vous permet d\'obtenir de nouvelles fonctions personnalisées.'
          );

          return $this->redirectToRoute('home');
        }
      }

      return $this->render('HomeBundle:Authentification:login.html.twig',
        array('form' => $form->createView(),
              'form_password' => $form_password->createView()));
    }

    public function logoutAction(Request $request)
    {
      $this->get("security.token_storage")->setToken(null);

      return $this->redirectToRoute('home');
    }
}
