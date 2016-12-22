<?php

namespace AppBundle\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Form\Type\UserType;
use AppBundle\Form\Type\UserSelect;
use AppBundle\Form\Type\UserNotification;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\Form\Form;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class AccountController extends Controller
{
		/**
     * @Route("/account/parameter/")
		 * @Method({"GET", "POST"})
     */
    public function parametersAction(Request $request)
    {
				$user = $this->getUser();

				$delete_form = $this->createForm(UserType::class, $user);
				$delete_form->handleRequest($request);
				if ($delete_form->isSubmitted() && $delete_form->isValid()) {
					if($delete_form->get('delete')->isClicked()){
						if($this->delete($user, $delete_form))
							return $this->redirectToRoute('homepage');
					}
				}

				$user_form = $this->createForm(UserType::class, $user);
				$user_form->handleRequest($request);
				$notification_form = $this->createForm(UserNotification::class, $user);
				$notification_form->handleRequest($request);
				$option_form = $this->createForm(UserSelect::class, $user);
				$option_form->handleRequest($request);
				if ($notification_form->isSubmitted() && $notification_form->isValid()
						|| $user_form->isSubmitted() && $user_form->isValid()
						|| $option_form->isSubmitted() && $option_form->isValid())
				{
					$this->save($user, $user_form, $notification_form, $option_form);
				}

				return $this->render('user/account/parameter.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
						'form_user' => $user_form->createView(),
						'delete_form' => $delete_form->createView(),
						'notification_form' => $notification_form->createView(),
						'option_form' => $option_form->createView(),
        ]);
    }

		/**
		* Function to save an account
		* @param User $user the user entity to save into database
		*/
		private function save(User $user, Form $user_form, Form $notification_form, Form $option_form)
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

		/**
		* @Route("account/calendar/")
		* @Method({"GET"})
		*/
		public function accountCalendarAction(){
			$em = $this->getDoctrine()->getManager();
			$repository = $em->getRepository('AppBundle:Course');
			$courses = $repository->findCourseWhereUserIsRegistered($this->getUser());
			return $this->render('user/calendar/calendar.html.twig', [
				'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
				'courses' => $courses,
			]);
		}
}
