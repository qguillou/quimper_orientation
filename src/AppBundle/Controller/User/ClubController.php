<?php

namespace AppBundle\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ClubController extends Controller
{

	/**
	* @Route("/club/presentation/")
	* @Method({"GET"})
	*/
	public function presentationAction()
	{
		return $this->render('user/club/presentation.html.twig', [
			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
		]);
	}

	/**
	* @Route("/club/rejoindre/")
	* @Method({"GET"})
	*/
	public function rejoindreAction()
	{
		$em = $this->getDoctrine()->getManager();
    $repository = $em->getRepository('AppBundle:Tarif');

    $licences = $repository->findAll();
		return $this->render('user/club/rejoindre.html.twig', [
			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
			'licences' => $licences,
		]);
	}

	/**
	* @Route("/club/ecole/")
	* @Method({"GET"})
	*/
	public function ecoleAction()
	{
		return $this->render('user/club/ecole.html.twig', [
			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
		]);
	}

	/**
	* @Route("/club/contact/")
	* @Method({"GET"})
	*/
	public function contactAction()
	{
		$em = $this->getDoctrine()->getManager();
    $repository = $em->getRepository('AppBundle:Contact');

    $contacts = $repository->findContact();
		return $this->render('user/club/contact.html.twig', [
			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
			'contacts' => $contacts,
		]);
	}
}
