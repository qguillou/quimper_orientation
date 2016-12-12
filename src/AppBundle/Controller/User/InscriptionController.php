<?php

namespace AppBundle\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class InscriptionController extends Controller
{
	/**
	* @Route("/inscription/")
	* @Method({"GET"})
	*/
	public function inscriptionAction()
	{
		return $this->render('user/inscription/inscription.html.twig', [
			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
		]);
	}

	/**
	* @Route("/inscription/consultation/")
	* @Method({"GET"})
	*/
	public function consultationAction()
	{
		return $this->render('user/inscription/consultation.html.twig', [
			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
		]);
	}

	/**
	* @Route("/inscription/inscrire/")
	* @Method({"GET"})
	*/
	public function inscrireAction()
	{
		return $this->render('user/inscription/inscrire.html.twig', [
			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
		]);
	}

	/**
	* @Route("/inscription/modification/")
	* @Method({"GET"})
	*/
	public function modificationAction()
	{
		return $this->render('user/inscription/modification.html.twig', [
			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
		]);
	}

	/**
	* @Route("/inscription/recuperation/")
	* @Method({"GET"})
	*/
	public function recuperationAction()
	{
		return $this->render('user/inscription/recuperation.html.twig', [
			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
		]);
	}
}
