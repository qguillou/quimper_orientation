<?php

namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\User\UserView;
use AppBundle\Entity\User;
use AppBundle\Entity\Role;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class InscriptionAdminController extends Controller
{
	/**
	* @Route("/admin/inscription/utilisateur/")
	*/
	public function utilisateur(Request $request)
	{
		$user = new User();
		return $this->renderUserAdminPage($request, $user);
	}

	/**
	* @Route("/admin/inscription/utilisateur/{id}/")
	*/
	public function utilisateurById($id, Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('AppBundle:User');
		$user = $repository->findOneBy(array('id' => $id));

		return $this->renderUserAdminPage($request, $user);
	}

	/**
	* Function to render the page
	* @param Request $request
	* @param User $user
	*/
	private function renderUserAdminPage(Request $request, User $user)
	{
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('AppBundle:User');
		$users = $repository->findAll();
		$session = $this->get('app.session');

		$form = $this->createForm(UserView::class, $user);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
      if($form->get('delete')->isClicked())
			return $this->delete($user);
			else
			return $this->promote($user);
		}

		return $this->render('admin/inscription/utilisateur.html.twig', [
				'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
				'user' => $this->getUser(),
				'isConnected' => $session->isAuthenticated(),
				'isAdmin' => $session->isAdmin(),
				'users' => $users,
				'active' => $user->getId(),
				'form' => $form->createView(),
		]);
	}

	/**
	* @Route("/admin/inscription/archive/")
	*/
	public function archive(){
		$session = $this->get('app.session');
		return $this->render('admin/inscription/archive.html.twig', [
			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
			'user' => $this->getUser(),
			'isConnected' => $session->isAuthenticated(),
			'isAdmin' => $session->isAdmin(),
		]);
	}

  /**
	* Function to delete an user
	* @param User $user the user entity to delete into database
	* @return the redirect view
	*/
	private function delete(User $user)
	{
    if($user->getId() != null){
      $em = $this->getDoctrine()->getManager();

      $repository = $em->getRepository('AppBundle:Role');
  		$role = $repository->findOneBy(array('user' => $user->getUsername()));
      if($role)
        $em->remove($role);

      $em->remove($user);
      $em->flush();

      $this->get('session')->getFlashBag()->add(
        'success',
        'L\'utilisateur '.$user->getUsername().' a été supprimée.'
      );
    }
    else {
      $this->get('session')->getFlashBag()->add(
        'error',
        'Veuillez sélectionner un utilisateur.'
      );
    }

		return $this->redirect('/admin/inscription/utilisateur/');
	}

  /**
	* Function to promote an user
	* @param User $user the user entity to delete into database
	* @return the redirect view
	*/
	private function promote(User $user)
	{
    $em = $this->getDoctrine()->getManager();

		try {
			$role = new Role();
			$role->setUser($user->getUsername());
			$role->setRole('ROLE_WEBMASTER');
			$em->persist($role);
			$em->flush();
			$this->get('session')->getFlashBag()->add(
				'success',
				'L\'utilisateur '.$user->getUsername().' a obtenu les droits d\'administration.'
			);
		}
		catch (UniqueConstraintViolationException $e){
			$this->get('session')->getFlashBag()->add(
				'error',
				'L\'utilisateur '.$user->getUsername().' avait déjà les droits d\'administration.'
			);
		}
    return $this->redirect('/admin/inscription/utilisateur/'.$user->getId());
  }
}
