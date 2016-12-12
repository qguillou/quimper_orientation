<?php

namespace AppBundle\Controller\User;

use AppBundle\Form\Type\LoginForm;
use AppBundle\Form\Type\UserPassword;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken,
Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class SessionController extends Controller
{
  /**
  * @Route("/login/", name="user_login")
  * @Method({"GET", "POST"})
  */
  public function loginAction(Request $request)
  {
    $user = new User();
    $form = $this->createForm(LoginForm::class, $user);
    $form->handleRequest($request);
    $form_password = $this->createForm(UserPassword::class, $user);
    $form_password->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $password = $this->get('security.password_encoder')
      ->encodePassword($user, $user->getPlainPassword());
      $user->setPassword($password);
      return $this->loginValidation($form, $form_password, $user, $request);
    }


    if ($form_password->isSubmitted() && $form_password->isValid()) {
      return $this->getNewPassword($form, $form_password, $user, $request);
    }

    return $this->render(
      'user/session/login.html.twig',
      array('form' => $form->createView(),
      'form_password' => $form_password->createView(),)
    );
  }

  private function loginValidation($form, $form_password, User $user, Request $request){
    $em = $this->getDoctrine()->getManager();
    $repository = $em->getRepository('AppBundle:User');
    $u = $repository->findOneBy(array('username' => $user->getUsername()));
    if($u){
      $factory = $this->get('security.encoder_factory');
      $encoder = $factory->getEncoder($u);
      if(($encoder->isPasswordValid($u->getPassword(),$user->getPlainPassword(),$u->getSalt()))){
        $token = new UsernamePasswordToken($u, $u->getPassword(), "public", $u->getRoles());
        $this->get("security.token_storage")->setToken($token);
        $event = new InteractiveLoginEvent($request, $token);
        $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);

        $this->get('session')->getFlashBag()->add(
          'success',
          'Bonjour '.$user->getPrenom().',
          Vous êtes maintenant connecté sur le site de Quimper Orientation.
          Ceci vous permet d\'obtenir de nouvelles fonctions personnalisées.'
        );
        return $this->redirectToRoute('homepage');
      }
    }

    $error = new FormError("Le nom d'utilisateur et le mot de passe ne correspondent pas.");
    $form->addError($error);

    return $this->render(
      'user/session/login.html.twig',
      array('form' => $form->createView(),
      'form_password' => $form_password->createView(),)
    );
  }

  private function getNewPassword($form, $form_password, User $user, Request $request)
  {
    $em = $this->getDoctrine()->getManager();
    $repository = $em->getRepository('AppBundle:User');
    $u = $repository->findOneBy(array('email' => $user->getEmail()));
    if($u){
      $pass = random_int(1000, 9999);
      $u->setPlainPassword($pass);
      $password = $this->get('security.password_encoder')
      ->encodePassword($u, $u->getPlainPassword());
      $u->setPassword($password);
      $em->persist($u);
      $em->flush();
      echo $pass;
      //Envoyer un email avec le nouveau password
      $message = \Swift_Message::newInstance()
      ->setSubject('Quimper Orientation')
      ->setFrom('no-reply@quimper-orientation.fr')
      ->setTo($u->getEmail())
      ->setBody(
        $this->renderView(
          'user/email/password.html.twig',
          array('user' => $u,
                'password' => $pass)
        ),
        'text/html'
        )
      ;
      $this->get('mailer')->send($message);

      $this->get('session')->getFlashBag()->add(
        'success',
        'Un email vient de vous être envoyé avec un nouveau mot de passe.'
      );

      return $this->redirectToRoute('user_login');
    }

    $error = new FormError("Le nom d'utilisateur et le mot de passe ne correspondent pas.");
    $form_password->addError($error);

    $this->get('session')->getFlashBag()->add(
      'error',
      'L\'adresse email que vous avez renseignée nous est inconnue, êtes-vous sur d\'avoir renseigné la bonne adresse ?'
    );

    return $this->render(
      'user/session/login.html.twig',
      array('form' => $form->createView(),
      'form_password' => $form_password->createView(),)
    );
}

/**
* @Route("/logout/", name="user_logout")
* @Method({"GET", "POST"})
*/
public function logoutAction()
{
  $this->get("security.token_storage")->setToken(null);
  return $this->redirectToRoute('homepage');
}
}
