<?php

namespace AppBundle\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\InscritUpdate;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

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
	* @Method({"GET", "POST"})
	*/
	public function modificationAction(Request $request)
	{
		$form = $this->createForm(InscritUpdate::class, $this->getUser());
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			try {
		    $em->persist($this->getUser());
		    $em->flush();

		    $this->get('session')->getFlashBag()->add(
		      'success',
		      'Les inscriptions ont été modifiés.'
		    );
			}
			catch (UniqueConstraintViolationException $e){
				$this->get('session')->getFlashBag()->add(
					'error',
					'Les inscription n\'ont pas pu être modifiée, une erreur est survenue.'
				);
			}

			return $this->redirect('/inscription/modification/');
		}

		return $this->render('user/inscription/modification.html.twig', [
			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
			'form' => $form->createView(),
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

	/**
	* Deletes an Inscrit
	*
	* @Route("/inscription/modification/delete/{id}", name="inscription_delete")
	* @Method({"GET", "DELETE"})
	*/
	public function deleteInscritAction(Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('AppBundle:Inscrit');
		$inscrit = $repository->findInscrit($this->getUser(), $id);
		if ($inscrit) {
			$em->remove($inscrit);
			$em->flush();

			$this->get('session')->getFlashBag()->add(
				'success',
				'La désinscription de '.$inscrit->getPrenom().' '.$inscrit->getNom().' a été effectuée.'
			);
		}

		return $this->redirect('/inscription/modification/');
	}
}
