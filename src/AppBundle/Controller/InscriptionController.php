<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\User\UserView;
use AppBundle\Entity\User;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class InscriptionController extends Controller
{
	/**
	* @Route("/inscription/")
	*/
	public function inscription()
	{
		$session = $this->get('app.session');
		return $this->render('user/inscription/inscription.html.twig', [
			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
			'user' => $this->getUser(),
			'isConnected' => $session->isAuthenticated(),
			'isAdmin' => $session->isAdmin(),
		]);
	}

	/**
	* @Route("/inscription/consultation/")
	*/
	public function consultation()
	{
		$session = $this->get('app.session');
		return $this->render('user/inscription/consultation.html.twig', [
			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
			'user' => $this->getUser(),
			'isConnected' => $session->isAuthenticated(),
			'isAdmin' => $session->isAdmin(),
		]);
	}

	/**
	* @Route("/inscription/inscrire/")
	*/
	public function inscrire()
	{
		$session = $this->get('app.session');
		return $this->render('user/inscription/inscrire.html.twig', [
			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
			'user' => $this->getUser(),
			'isConnected' => $session->isAuthenticated(),
			'isAdmin' => $session->isAdmin(),
		]);
	}

	/**
	* @Route("/inscription/modification/")
	*/
	public function modification()
	{
		$session = $this->get('app.session');
		return $this->render('user/inscription/modification.html.twig', [
			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
			'user' => $this->getUser(),
			'isConnected' => $session->isAuthenticated(),
			'isAdmin' => $session->isAdmin(),
		]);
	}

	/**
	* @Route("/inscription/recuperation/")
	*/
	public function recuperation()
	{
		$session = $this->get('app.session');
		return $this->render('user/inscription/recuperation.html.twig', [
			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
			'user' => $this->getUser(),
			'isConnected' => $session->isAuthenticated(),
			'isAdmin' => $session->isAdmin(),
		]);
	}

	/**
	* @Route("/admin/inscription/utilisateur/")
	*/
	public function utilisateur(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('AppBundle:User');
		$users = $repository->findAll();
		$session = $this->get('app.session');

		$user = new User();
		$form = $this->createForm(UserView::class, $user);
		$form->handleRequest($request);

		return $this->render('admin/inscription/utilisateur.html.twig', [
				'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
				'user' => $this->getUser(),
				'isConnected' => $session->isAuthenticated(),
				'isAdmin' => $session->isAdmin(),
				'users' => $users,
				'active' => 0,
				'form' => $form->createView(),
		]);
	}

	/**
	* @Route("/admin/inscription/utilisateur/{id}/")
	*/
	public function utilisateurById($id, Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('AppBundle:User');
		$users = $repository->findAll();
		$session = $this->get('app.session');

		$user = $repository->findOneBy(array('id' => $id));
		$form = $this->createForm(UserView::class, $user);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
      $repository = $em->getRepository('AppBundle:User');
      $user = $repository->findOneBy(array('id' => $id));
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
				'active' => $id,
				'form' => $form->createView(),
		]);
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
