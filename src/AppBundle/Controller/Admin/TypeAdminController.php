<?php

namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\TypeType;
use AppBundle\Entity\Type;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\Form\Form;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class TypeAdminController extends Controller
{
	/**
	* @Route("/admin/type/")
	* @Method({"GET", "POST"})
	*/
	public function adminTypeAction(Request $request)
	{
		$type = new Type();
		return $this->renderTypeAdminPage($request, $type);
	}

	/**
	* @Route("/admin/type/{id}/")
	* @Method({"GET", "POST"})
	*/
	public function adminTypeByIdAction($id, Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('AppBundle:Type');
		$type = $repository->findOneBy(array('id' => $id));

		return $this->renderTypeAdminPage($request, $type);
	}

	/**
	* Function to render the page
	* @param Request $request
	* @param Type $type
	*/
	private function renderTypeAdminPage(Request $request, Type $type)
	{
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('AppBundle:Type');
		$types = $repository->findAll();

		$form = $this->createForm(TypeType::class, $type);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			if($form->get('save')->isClicked())
			return $this->save($type, $form);
			else
			return $this->delete($type);
		}

		return $this->render('admin/calendar/type.html.twig', [
			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
			'types' => $types,
			'form' => $form->createView(),
		]);
	}

	/**
	* Function to save a map
	* @param Type $type the map entity to save into database
	* @return the redirect view
	*/
	private function save(Type $type, Form $form)
	{
		try {
			$em = $this->getDoctrine()->getManager();
			$em->persist($type);
			$em->flush();
		}
		catch (UniqueConstraintViolationException $e){
			$this->get('session')->getFlashBag()->add(
				'error',
				'La type '.$type->getNom().' n\'a pas pu être modifiée, une erreur est survenue.'
			);

      $em = $this->getDoctrine()->getManager();
  		$repository = $em->getRepository('AppBundle:Type');
  		$types = $repository->findAll();

			return $this->render(
				'admin/calendar/type.html.twig',
				array('form' => $form->createView(),
				'types' => $types)
			);
		}

		$this->get('session')->getFlashBag()->add(
			'success',
			'La type '.$type->getNom().' a été modifiée.'
		);
		return $this->redirect('/admin/type/'.$type->getId());
	}

	/**
	* Function to delete a map
	* @param Type $type the map entity to delete into database
	* @return the redirect view
	*/
	private function delete(Type $type)
	{
		$em = $this->getDoctrine()->getManager();
		$em->remove($type);
		$em->flush();

		$this->get('session')->getFlashBag()->add(
			'success',
			'La type '.$type->getNom().' a été supprimée.'
		);

		return $this->redirect('/admin/type/');
	}
}
