<?php
namespace AppBundle\Controller;

use AppBundle\Form\User\UserType;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\EventDispatcher\EventDispatcher,
Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken,
Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class RegistrationController extends Controller
{
  /**
  * @Route("/register/", name="user_registration")
  */
  public function registerAction(Request $request)
  {
    $session = $this->get('app.session');

    $user = new User();
    $form = $this->createForm(UserType::class, $user);

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid() && !$this->registerValidation($form, $user)) {
      $password = $this->get('security.password_encoder')
      ->encodePassword($user, $user->getPlainPassword());
      $user->setPassword($password);
      $user->setNewsletter(true);

      try {
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
      }
      catch (UniqueConstraintViolationException $e){
        return $this->render(
          'user/session/register.html.twig',
          array('form' => $form->createView(),
          'user' => $this->getUser(),
          'isConnected' => $session->isAuthenticated(),
          'isAdmin' => $session->isAdmin(),)
        );
      }

      $token = new UsernamePasswordToken($user, $user->getPassword(), "public", $user->getRoles());
      $this->get("security.token_storage")->setToken($token);
      $event = new InteractiveLoginEvent($request, $token);
      $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);
      return $this->redirectToRoute('homepage');
    }

    return $this->render(
      'user/session/register.html.twig',
      array('form' => $form->createView(),
      'user' => $this->getUser(),
      'isConnected' => $session->isAuthenticated(),
      'isAdmin' => $session->isAdmin(),)
    );
  }

  private function registerValidation($form, User $user){
    $error = false;

    $em = $this->getDoctrine()->getManager();
    $repository = $em->getRepository('AppBundle:User');

    $u = $repository->findOneBy(array('username' => $user->getUsername()));
    if($u){
      $error = new FormError("Ce nom d'utilisateur est déjà utilisé.");
      $form->get('username')->addError($error);
      $error = true;
    }

    $u = $repository->findOneBy(array('email' => $user->getEmail()));
    if($u){
      $error = new FormError("Cette adresse email est déjà utilisée.");
      $form->get('email')->addError($error);
      $error = true;
    }

    $u = $repository->findOneBy(array('license' => $user->getLicense()));
    if($u && $user->getLicense() != null && $user->getLicense() != ""){
      $error = new FormError("Ce numéro de licence est déjà utilisée.");
      $form->get('license')->addError($error);
      $error = true;
    }

    return $error;
  }
}
