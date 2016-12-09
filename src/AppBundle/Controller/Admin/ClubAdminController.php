<?php

namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Controller\DefaultController;
use AppBundle\Entity\Tarif;
use AppBundle\Entity\Contact;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Tarif\TarifType;
use AppBundle\Form\Contact\ContactType;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class ClubAdminController extends Controller
{
	/**
	* @Route("/admin/club/tarif/")
	*/
	public function adminTarif(Request $request)
	{
		$tarif = new Tarif();
		return $this->renderTarifAdminPage($request, $tarif);
	}

	/**
	* @Route("/admin/club/tarif/{id}/")
	*/
	public function adminTarifById($id, Request $request)
	{
		$em = $this->getDoctrine()->getManager();
    $repository = $em->getRepository('AppBundle:Tarif');
		$tarif = $repository->findOneBy(array('id' => $id));
		return $this->renderTarifAdminPage($request, $tarif);
	}

  /**
	* Function to render the page
	* @param Request $request
	* @param Tarif $tarif
	*/
	private function renderTarifAdminPage(Request $request, Tarif $tarif)
	{
    $session = $this->get('app.session');
    $em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('AppBundle:Tarif');
		$tarifs = $repository->findAll();


		$form = $this->createForm(TarifType::class, $tarif);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
      if($form->get('save')->isClicked())
			return $this->save($tarif);
			else
			return $this->delete($tarif);
		}

		return $this->render('admin/club/tarif.html.twig', [
				'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
				'user' => $this->getUser(),
				'isConnected' => $session->isAuthenticated(),
				'isAdmin' => $session->isAdmin(),
				'tarifs' => $tarifs,
				'active' => $tarif->getId(),
				'form' => $form->createView(),
		]);
  }

  /**
  * Function to save a tarif
	* @param Tarif $tarif the tarif entity to save into database
	* @return the redirect view
  */
  private function save($tarif)
  {
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
        'active' => $tarif->getId(),
        'tarifs' => $tarifs)
      );
    }

    $this->get('session')->getFlashBag()->add(
      'success',
      'Le tarif '.$tarif->getNom().' a été modifiée.'
    );
    return $this->redirect('/admin/club/tarif/'.$tarif->getId());
  }

  /**
	* Function to delete a tarif
	* @param Tarif $tarif the tarif entity to delete into database
	* @return the redirect view
	*/
	private function delete(Tarif $tarif)
	{
		$em = $this->getDoctrine()->getManager();
		$em->remove($tarif);
		$em->flush();

		$this->get('session')->getFlashBag()->add(
			'success',
			'Le tarif '.$tarif->getNom().' a été supprimée.'
		);

		return $this->redirect('/admin/club/tarif/');
	}

	/**
	* @Route("/admin/club/contact/")
	*/
	public function adminContact(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('AppBundle:Contact');
		$contacts = $repository->findAll();
		$session = $this->get('app.session');

		$contact = new Contact();
		$form = $this->createForm(ContactType::class, $contact);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			try {
				$em->persist($contact);
				$em->flush();
			}
			catch (UniqueConstraintViolationException $e){
				$this->get('session')->getFlashBag()->add(
					'error',
					'Le contact '.$contact->getFonction().' n\'a pas pu être créée, une erreur est survenue.'
				);
				return $this->render(
					'admin/club/contact.html.twig',
					array('form' => $form->createView(),
					'user' => $this->getUser(),
					'isConnected' => $session->isAuthenticated(),
					'isAdmin' => $session->isAdmin(),
					'active' => 0,
					'contacts' => $contacts)
				);
			}

			$this->get('session')->getFlashBag()->add(
				'success',
				'Le contact '.$contact->getFonction().' a été créée.'
			);

			return $this->redirect('/admin/club/contact/'.$contact->getId());
		}

		return $this->render('admin/club/contact.html.twig', [
				'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
				'user' => $this->getUser(),
				'isConnected' => $session->isAuthenticated(),
				'isAdmin' => $session->isAdmin(),
				'contacts' => $contacts,
				'active' => 0,
				'form' => $form->createView(),
		]);
	}

	/**
	* @Route("/admin/club/contact/{id}/")
	*/
	public function adminContactById($id, Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('AppBundle:Contact');
		$contacts = $repository->findAll();
		$session = $this->get('app.session');

		$contact = $repository->findOneBy(array('id' => $id));
		$form = $this->createForm(ContactType::class, $contact);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			try {
				$em = $this->getDoctrine()->getManager();
				$em->persist($contact);
				$em->flush();
			}
			catch (UniqueConstraintViolationException $e){
				$this->get('session')->getFlashBag()->add(
					'error',
					'Le contact '.$contact->getFonction().' n\'a pas pu être modifiée, une erreur est survenue.'
				);
				return $this->render(
					'admin/club/contact.html.twig',
					array('form' => $form->createView(),
					'user' => $this->getUser(),
					'isConnected' => $session->isAuthenticated(),
					'isAdmin' => $session->isAdmin(),
					'active' => $id,
					'contacts' => $contacts)
				);
			}

			$this->get('session')->getFlashBag()->add(
				'success',
				'Le contact '.$contact->getFonction().' a été modifiée.'
			);
			return $this->redirect('/admin/club/contact/'.$id);
		}

		return $this->render('admin/club/contact.html.twig', [
				'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
				'user' => $this->getUser(),
				'isConnected' => $session->isAuthenticated(),
				'isAdmin' => $session->isAdmin(),
				'contacts' => $contacts,
				'active' => $id,
				'form' => $form->createView(),
		]);
	}

	/**
	*@Route("/admin/club/contact/delete/{id}/")
	*/
	public function deleteContact($id)
	{
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('AppBundle:Contact');
		$contact = $repository->findOneBy(array('id' => $id));
		$em->remove($contact);
		$em->flush();

		$this->get('session')->getFlashBag()->add(
			'success',
			'Le contact '.$contact->getFonction().' a été supprimée.'
		);

		return $this->redirect('/admin/club/contact/');
	}
}
