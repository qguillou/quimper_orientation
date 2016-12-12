<?php

namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Tarif;
use AppBundle\Entity\Contact;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\TarifType;
use AppBundle\Form\Type\ContactType;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class ClubAdminController extends Controller
{
	/**
	* @Route("/admin/club/tarif/")
	*/
	public function adminTarifAction(Request $request)
	{
		$tarif = new Tarif();
		return $this->renderTarifAdminPage($request, $tarif);
	}

	/**
	* @Route("/admin/club/tarif/{id}/")
	*/
	public function adminTarifByIdAction($id, Request $request)
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
			return $this->saveTarif($tarif);
			else
			return $this->deleteTarif($tarif);
		}

		return $this->render('admin/club/tarif.html.twig', [
				'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
				'tarifs' => $tarifs,
				'form' => $form->createView(),
		]);
  }

  /**
  * Function to save a tarif
	* @param Tarif $tarif the tarif entity to save into database
	* @return the redirect view
  */
  private function saveTarif(Tarif $tarif)
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

			$em = $this->getDoctrine()->getManager();
			$repository = $em->getRepository('AppBundle:Tarif');
			$tarifs = $repository->findAll();

      return $this->render(
        'admin/club/tarif.html.twig',
        array('form' => $form->createView(),
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
	private function deleteTarif(Tarif $tarif)
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
  public function adminContactAction(Request $request)
  {
    $contact = new Contact();
    return $this->renderContactAdminPage($request, $contact);
  }

  /**
  * @Route("/admin/club/contact/{id}/")
  */
  public function adminContactByIdAction($id, Request $request)
  {
    $em = $this->getDoctrine()->getManager();
    $repository = $em->getRepository('AppBundle:Contact');
    $contact = $repository->findOneBy(array('id' => $id));
    return $this->renderContactAdminPage($request, $contact);
  }

  /**
  * Function to render the page
  * @param Request $request
  * @param Contact $contact
  */
  private function renderContactAdminPage(Request $request, Contact $contact)
  {
    $session = $this->get('app.session');
    $em = $this->getDoctrine()->getManager();
    $repository = $em->getRepository('AppBundle:Contact');
    $contacts = $repository->findAll();


    $form = $this->createForm(ContactType::class, $contact);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      if($form->get('save')->isClicked())
      return $this->saveContact($contact);
      else
      return $this->deleteContact($contact);
    }

    return $this->render('admin/club/contact.html.twig', [
        'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        'contacts' => $contacts,
        'form' => $form->createView(),
    ]);
  }

  /**
  * Function to save a contact
  * @param Contact $contact the contact entity to save into database
  * @return the redirect view
  */
  private function saveContact(Contact $contact)
  {
    try {
      $em = $this->getDoctrine()->getManager();
      $em->persist($contact);
      $em->flush();
    }
    catch (UniqueConstraintViolationException $e){
      $this->get('session')->getFlashBag()->add(
        'error',
        'Le contact '.$contact->getNom().' n\'a pas pu être modifiée, une erreur est survenue.'
      );

			$em = $this->getDoctrine()->getManager();
			$repository = $em->getRepository('AppBundle:Contact');
			$contacts = $repository->findAll();

      return $this->render(
        'admin/club/contact.html.twig',
        array('form' => $form->createView(),
        'contacts' => $contacts)
      );
    }

    $this->get('session')->getFlashBag()->add(
      'success',
      'Le contact '.$contact->getNom().' a été modifiée.'
    );
    return $this->redirect('/admin/club/contact/'.$contact->getId());
  }

  /**
  * Function to delete a contact
  * @param Contact $contact the contact entity to delete into database
  * @return the redirect view
  */
  private function deleteContact(Contact $contact)
  {
    $em = $this->getDoctrine()->getManager();
    $em->remove($contact);
    $em->flush();

    $this->get('session')->getFlashBag()->add(
      'success',
      'Le contact '.$contact->getNom().' a été supprimée.'
    );

    return $this->redirect('/admin/club/contact/');
  }
}
