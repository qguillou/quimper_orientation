<?php

namespace AppBundle\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ParcoursPermanentController extends Controller
{
	/**
	* @Route("/parcours/")
	* @Method({"GET"})
	*/
	public function parcoursAction()
	{
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('AppBundle:Cartes');
		$cartes = $repository->findCartes();
		return $this->render('user/parcours/parcours.html.twig', [
			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
			'cartes' => $cartes,
		]);
	}

	/**
	* @Route("/parcours/{id}/")
	* @Method({"GET", "POST"})
	*/
	public function getParcoursAction($id)
	{
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('AppBundle:Cartes');
		$carte = $repository->findOneBy(array('id' => $id));
		$carte->setNbTelechargement($carte->getNbTelechargement() + 1);

		try {
			$em->persist($carte);
			$em->flush();
		}
		catch (UniqueConstraintViolationException $e){
			return $this->redirect('/files/cartes/'.$id.'.pdf');
		}

		return $this->redirect('/files/cartes/'.$id.'.pdf');
	}
}
