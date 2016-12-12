<?php

namespace AppBundle\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Form\User\UserUpdate;
use AppBundle\Form\User\UserDelete;
use AppBundle\Form\User\UserNotification;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\Form\Form;

class AccountController extends Controller
{
		/**
     * @Route("/account/")
     */
    public function accountAction()
    {
				$session = $this->get('app.session');
        return $this->render('user/account/account.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
						'user' => $this->getUser(),
						'isConnected' => $session->isAuthenticated(),
            'isAdmin' => $session->isAdmin(),
        ]);
    }

		/**
     * @Route("/account/parameter/")
     */
    public function parametersAction(Request $request)
    {
				$session = $this->get('app.session');

				$user = $this->getUser();

				$delete_form = $this->createForm(UserDelete::class, $user);
				$delete_form->handleRequest($request);
				if ($delete_form->isSubmitted() && $delete_form->isValid()) {
					if($this->delete($user, $delete_form))
						return $this->redirectToRoute('homepage');
				}

				$user_form = $this->createForm(UserUpdate::class, $user);
				$user_form->handleRequest($request);
				$notification_form = $this->createForm(UserNotification::class, $user);
				$notification_form->handleRequest($request);
				if ($notification_form->isSubmitted() && $notification_form->isValid()
						|| $user_form->isSubmitted() && $user_form->isValid())
				{
					$this->save($user, $user_form, $notification_form);
				}

				return $this->render('user/account/parameter.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
						'user' => $this->getUser(),
						'isConnected' => $session->isAuthenticated(),
            'isAdmin' => $session->isAdmin(),
						'user_form' => $user_form->createView(),
						'delete_form' => $delete_form->createView(),
						'notification_form' => $notification_form->createView(),
        ]);
    }

		/**
		* Function to save an account
		* @param User $user the user entity to save into database
		*/
		private function save(User $user, Form $user_form, Form $notification_form)
		{
			if($user->getPlainPassword()){
				$password = $this->get('security.password_encoder')
						->encodePassword($user, $user->getPlainPassword());
				$user->setPassword($password);
			}

			try {
					$em = $this->getDoctrine()->getManager();
					$em->persist($user);
					$em->flush();
					$this->get('session')->getFlashBag()->add(
						'success',
						'Les modifications du profil ont été prises en compte.'
					);
			}
			catch (UniqueConstraintViolationException $e){
					$this->get('session')->getFlashBag()->add(
						'error',
						'Les modifications du profil n\'ont pas été effectuées, une erreur est survenue.'
					);
			}
		}

		/**
		* Function to delete a user
		* @param User $user the user entity to delete into database
		* @return the redirect view
		*/
		private function delete(User $user, Form $delete_form)
		{
			$factory = $this->get('security.encoder_factory');
			$encoder = $factory->getEncoder($user);
			if(($encoder->isPasswordValid($user->getPassword(),$user->getPlainPassword(),$user->getSalt()))){
				$this->get("security.token_storage")->setToken(null);
				$em = $this->getDoctrine()->getManager();

				$repository = $em->getRepository('AppBundle:Role');
	  		$role = $repository->findOneBy(array('user' => $user->getUsername()));
	      if($role)
	        $em->remove($role);

				$em->remove($user);
				$em->flush();
				$this->get('session')->getFlashBag()->add(
					'success',
					'Votre compte a été supprimé.'
				);
				return true;
			}
			else {
				$this->get('session')->getFlashBag()->add(
					'error',
					'Le compte n\'a pas pu être supprimé, une erreur est survenue.'
				);
				$error = new FormError("Le mot de passe est incorrect.");
				$delete_form->get('plainPassword')->addError($error);
				return false;
			}
		}
}
