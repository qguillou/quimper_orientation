<?php

namespace AppBundle\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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
		]);
	}

	/**
	* @Route("/club/rejoindre/")
	*/
	public function rejoindreAction()
	{
		$em = $this->getDoctrine()->getManager();
    $repository = $em->getRepository('AppBundle:Tarif');

    $licences = $repository->findAll();
		$session = $this->get('app.session');
		return $this->render('user/club/rejoindre.html.twig', [
			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
			'licences' => $licences,
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
		]);
	}

	/**
	* @Route("/club/contact/")
	*/
	public function contactAction()
	{
		$em = $this->getDoctrine()->getManager();
    $repository = $em->getRepository('AppBundle:Contact');

    $contacts = $repository->findAll();
		$session = $this->get('app.session');
		return $this->render('user/club/contact.html.twig', [
			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
			'contacts' => $contacts,
		]);
	}
}
