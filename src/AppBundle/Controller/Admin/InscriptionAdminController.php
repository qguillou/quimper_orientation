<?php

namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\User\UserView;
use AppBundle\Entity\User;
use AppBundle\Entity\Role;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class InscriptionAdminController extends Controller
{
	/**
	* @Route("/admin/inscription/utilisateur/")
	*/
	public function utilisateur(Request $request)
	{
		$user = new User();
		return $this->renderUserAdminPage($request, $user);
	}

	/**
	* @Route("/admin/inscription/utilisateur/{id}/")
	*/
	public function utilisateurById($id, Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('AppBundle:User');
		$user = $repository->findOneBy(array('id' => $id));

		return $this->renderUserAdminPage($request, $user);
	}

	/**
	* Function to render the page
	* @param Request $request
	* @param User $user
	*/
	private function renderUserAdminPage(Request $request, User $user)
	{
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('AppBundle:User');
		$users = $repository->findAll();
		$session = $this->get('app.session');

		$form = $this->createForm(UserView::class, $user);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
      $repository = $em->getRepository('AppBundle:User');
      $user = $repository->findOneBy(array('id' => $user->getId()));
      $em->remove($user);
      $em->flush();

			//Ajout d'un message d'enregistrement effectué

			return $this->redirect('/admin/inscription/utilisateur/');
		}

		return $this->render('admin/inscription/utilisateur.html.twig', [
				'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
				'user' => $this->getUser(),
				'isConnected' => $session->isAuthenticated(),
				'isAdmin' => $session->isAdmin(),
				'users' => $users,
				'active' => $user->getId(),
				'form' => $form->createView(),
		]);
	}

	/**
	* @Route("/admin/inscription/utilisateur/{id}/webmaster")
	*/
	public function promoteToWebmaster($id)
	{
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('AppBundle:User');
		$user = $repository->findOneBy(array('id' => $id));

		try {
			$role = new Role();
			$role->setUser($user->getUsername());
			$role->setRole('ROLE_WEBMASTER');
			$em->persist($role);
			$em->flush();
			$this->get('session')->getFlashBag()->add(
				'success',
				'L\'utilisateur '.$user->getUsername().' a obtenu les droits d\'administration.'
			);
		}
		catch (UniqueConstraintViolationException $e){
			$this->get('session')->getFlashBag()->add(
				'error',
				'L\'utilisateur '.$user->getUsername().' a déjà les droits d\'administration.'
			);
		}
		return $this->redirect('/admin/inscription/utilisateur/'.$user->getId().'/');
	}

	/**
	* @Route("/admin/inscription/archive/")
	*/
	public function archive(){
		$session = $this->get('app.session');
		return $this->render('admin/inscription/archive.html.twig', [
			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
			'user' => $this->getUser(),
			'isConnected' => $session->isAuthenticated(),
			'isAdmin' => $session->isAdmin(),
		]);
	}
}
