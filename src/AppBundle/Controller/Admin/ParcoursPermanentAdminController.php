<?php

namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\CarteType;
use AppBundle\Entity\Cartes;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\Form\Form;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ParcoursPermanentAdminController extends Controller
{
	/**
	* @Route("/admin/parcours/")
	* @Method({"GET", "POST"})
	*/
	public function adminParcoursAction(Request $request)
	{
		$carte = new Cartes();
		return $this->renderMapAdminPage($request, $carte);
	}

	/**
	* @Route("/admin/parcours/{id}/")
	* @Method({"GET", "POST"})
	*/
	public function adminParcoursByIdAction($id, Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('AppBundle:Cartes');
		$carte = $repository->findOneBy(array('id' => $id));

		return $this->renderMapAdminPage($request, $carte);
	}

	/**
	* Function to render the page
	* @param Request $request
	* @param Cartes $carte
	*/
	private function renderMapAdminPage(Request $request, Cartes $carte)
	{
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('AppBundle:Cartes');
		$cartes = $repository->findAll();

		$form = $this->createForm(CarteType::class, $carte);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			if($form->get('save')->isClicked())
			return $this->save($carte, $form);
			else
			return $this->delete($carte);
		}

		return $this->render('admin/parcours/parcours.html.twig', [
			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
			'cartes' => $cartes,
			'form' => $form->createView(),
		]);
	}

	/**
	* Function to save a map
	* @param Carte $carte the map entity to save into database
	* @return the redirect view
	*/
	private function save(Cartes $carte, Form $form)
	{
		try {
			$carte->setDateModification(new \DateTime());
			$carte->setNbTelechargement(0);

			$em = $this->getDoctrine()->getManager();
			$em->persist($carte);
			$em->flush();

			if($form->get('file')->getData()){
				$form->get('file')->getData()->move($this->getParameter('cartes'), $carte->getId() . '.pdf');
			}
		}
		catch (UniqueConstraintViolationException $e){
			$this->get('session')->getFlashBag()->add(
				'error',
				'La carte '.$carte->getNom().' n\'a pas pu être modifiée, une erreur est survenue.'
			);

			$em = $this->getDoctrine()->getManager();
			$repository = $em->getRepository('AppBundle:Cartes');
			$cartes = $repository->findAll();

			return $this->render(
				'admin/parcours/parcours.html.twig',
				array('form' => $form->createView(),
				'cartes' => $cartes)
			);
		}

		$this->get('session')->getFlashBag()->add(
			'success',
			'La carte '.$carte->getNom().' a été modifiée.'
		);
		return $this->redirect('/admin/parcours/'.$carte->getId());
	}

	/**
	* Function to delete a map
	* @param Carte $carte the map entity to delete into database
	* @return the redirect view
	*/
	private function delete(Cartes $carte)
	{
		$em = $this->getDoctrine()->getManager();
		$file = $this->getParameter('cartes').'/'.$carte->getId().'.pdf';
		$em->remove($carte);
		$em->flush();

		if(file_exists($file)){
			unlink($file);
		}

		$this->get('session')->getFlashBag()->add(
			'success',
			'La carte '.$carte->getNom().' a été supprimée.'
		);

		return $this->redirect('/admin/parcours/');
	}
}
