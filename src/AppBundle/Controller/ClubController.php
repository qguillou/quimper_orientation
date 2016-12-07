<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Controller\DefaultController;

class ClubController extends Controller
{

	/**
	* @Route("/club/presentation/")
	*/
	public function presentationAction()
	{
		$session = $this->get('app.session');
		return $this->render('user/club/presentation.html.twig', [
			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
			'user' => $this->getUser(),
			'isConnected' => $session->isAuthenticated(),
			'isAdmin' => $session->isAdmin(),
		]);
	}

	/**
	* @Route("/club/rejoindre/")
	*/
	public function rejoindreAction()
	{
		$session = $this->get('app.session');
		return $this->render('user/club/rejoindre.html.twig', [
			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
			'user' => $this->getUser(),
			'isConnected' => $session->isAuthenticated(),
			'isAdmin' => $session->isAdmin(),
		]);
	}

	/**
	* @Route("/club/ecole/")
	*/
	public function ecoleAction()
	{
		$session = $this->get('app.session');
		return $this->render('user/club/ecole.html.twig', [
			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
			'user' => $this->getUser(),
			'isConnected' => $session->isAuthenticated(),
			'isAdmin' => $session->isAdmin(),
		]);
	}

	/**
	* @Route("/club/contact/")
	*/
	public function contactAction()
	{
		$session = $this->get('app.session');
		return $this->render('user/club/contact.html.twig', [
			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
			'user' => $this->getUser(),
			'isConnected' => $session->isAuthenticated(),
			'isAdmin' => $session->isAdmin(),
		]);
	}
}
