<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Controller\DefaultController;
use AppBundle\Entity\Tarif;
use AppBundle\Entity\Contact;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Tarif\TarifType;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

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
		$em = $this->getDoctrine()->getManager();
    $repository = $em->getRepository('AppBundle:Tarif');

    $licences = $repository->findAll();
		$session = $this->get('app.session');
		return $this->render('user/club/rejoindre.html.twig', [
			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
			'user' => $this->getUser(),
			'isConnected' => $session->isAuthenticated(),
			'isAdmin' => $session->isAdmin(),
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
		$em = $this->getDoctrine()->getManager();
    $repository = $em->getRepository('AppBundle:Contact');

    $contacts = $repository->findAll();
		$session = $this->get('app.session');
		return $this->render('user/club/contact.html.twig', [
			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
			'user' => $this->getUser(),
			'isConnected' => $session->isAuthenticated(),
			'isAdmin' => $session->isAdmin(),
			'contacts' => $contacts,
		]);
	}

	/**
	* @Route("/admin/club/tarif/")
	*/
	public function adminTarif(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('AppBundle:Tarif');
		$tarifs = $repository->findAll();
		$session = $this->get('app.session');

		$tarif = new Tarif();
		$form = $this->createForm(TarifType::class, $tarif);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			try {
				$em->persist($tarif);
				$em->flush();
			}
			catch (UniqueConstraintViolationException $e){
				$this->get('session')->getFlashBag()->add(
					'error',
					'Le tarif '.$tarif->getNom().' n\'a pas pu être créée, une erreur est survenue.'
				);
				return $this->render(
					'admin/club/tarif.html.twig',
					array('form' => $form->createView(),
					'user' => $this->getUser(),
					'isConnected' => $session->isAuthenticated(),
					'isAdmin' => $session->isAdmin(),
					'active' => 0)
				);
			}

			$this->get('session')->getFlashBag()->add(
				'success',
				'Le tarif '.$tarif->getNom().' a été créée.'
			);

			return $this->redirect('/admin/club/tarif/'.$tarif->getId());
		}

		return $this->render('admin/club/tarif.html.twig', [
				'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
				'user' => $this->getUser(),
				'isConnected' => $session->isAuthenticated(),
				'isAdmin' => $session->isAdmin(),
				'tarifs' => $tarifs,
				'active' => 0,
				'form' => $form->createView(),
		]);
	}

	/**
	* @Route("/admin/club/tarif/{id}/")
	*/
	public function adminTarifById($id, Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('AppBundle:Tarif');
		$tarifs = $repository->findAll();
		$session = $this->get('app.session');

		$tarif = $repository->findOneBy(array('id' => $id));
		$form = $this->createForm(TarifType::class, $tarif);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			try {
				$em = $this->getDoctrine()->getManager();
				$em->persist($tarif);
				$em->flush();
			}
			catch (UniqueConstraintViolationException $e){
				$this->get('session')->getFlashBag()->add(
					'error',
					'Le tarif '.$tarif->getNom().' n\'a pas pu être modifiée, une erreur est survenue.'
				);
				return $this->render(
					'admin/club/tarif.html.twig',
					array('form' => $form->createView(),
					'user' => $this->getUser(),
					'isConnected' => $session->isAuthenticated(),
					'isAdmin' => $session->isAdmin(),
					'active' => $id,
					'tarifs' => $tarifs)
				);
			}

			$this->get('session')->getFlashBag()->add(
				'success',
				'Le tarif '.$tarif->getNom().' a été modifiée.'
			);
			return $this->redirect('/admin/club/tarif/'.$id);
		}

		return $this->render('admin/club/tarif.html.twig', [
				'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
				'user' => $this->getUser(),
				'isConnected' => $session->isAuthenticated(),
				'isAdmin' => $session->isAdmin(),
				'tarifs' => $tarifs,
				'active' => $id,
				'form' => $form->createView(),
		]);
	}

	/**
	*@Route("/admin/club/tarif/delete/{id}/")
	*/
	public function deleteTarif($id)
	{
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('AppBundle:Tarif');
		$tarif = $repository->findOneBy(array('id' => $id));
		$em->remove($tarif);
		$em->flush();

		$this->get('session')->getFlashBag()->add(
			'success',
			'Le tarif '.$tarif->getNom().' a été supprimée.'
		);

		return $this->redirect('/admin/club/tarif/');
	}
}
