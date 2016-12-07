<?php

namespace AppBundle\Controller;

use AppBundle\Form\LoginForm;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\EventDispatcher\EventDispatcher,
Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken,
Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class SessionController extends Controller
{
  /**
  * @Route("/login/", name="user_login")
  */
  public function loginAction(Request $request)
  {
    $user = new User();
    $form = $this->createForm(LoginForm::class, $user);

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $password = $this->get('security.password_encoder')
      ->encodePassword($user, $user->getPlainPassword());
      $user->setPassword($password);

      return $this->loginValidation($form, $user, $request);
    }

    return $this->render(
      'user/session/login.html.twig',
      array('form' => $form->createView(),
      'isConnected' => false)
    );
  }

  private function loginValidation($form, User $user, Request $request){
    $em = $this->getDoctrine()->getManager();
    $repository = $em->getRepository('AppBundle:User');
    $u = $repository->findOneBy(array('username' => $user->getUsername()));
    if($u){
      $factory = $this->get('security.encoder_factory');
      $encoder = $factory->getEncoder($u);
      if(($encoder->isPasswordValid($u->getPassword(),$user->getPlainPassword(),$u->getSalt()))){
        $repository = $em->getRepository('AppBundle:Role');
        $r = $repository->findOneBy(array('user' => $u->getUsername()));
        $role = "ROLE_USER";
        if($r){
          $role = $r->getRole();
        }

        $token = new UsernamePasswordToken($u, $u->getPassword(), "public", array($role));
        $this->get("security.token_storage")->setToken($token);
        $event = new InteractiveLoginEvent($request, $token);
        $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);
        return $this->redirectToRoute('homepage');
      }
    }

    $error = new FormError("Le nom d'utilisateur et le mot de passe ne correspondent pas.");
    $form->addError($error);

    return $this->render(
      'user/session/login.html.twig',
      array('form' => $form->createView(),
      'isConnected' => false)
    );
  }

  /**
  * @Route("/logout/", name="user_logout")
  */
  public function logout()
  {
    $this->get("security.token_storage")->setToken(null);
    return $this->redirectToRoute('homepage');
  }
}
