<?php

namespace AppBundle\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\User\UserView;
use AppBundle\Entity\User;
use AppBundle\Entity\Role;
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
}
