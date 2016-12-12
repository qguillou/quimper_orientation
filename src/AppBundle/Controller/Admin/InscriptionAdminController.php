<?php

namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\UserView;
use AppBundle\Entity\User;
use AppBundle\Entity\Role;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use AppBundle\Entity\Base;
use AppBundle\Form\Type\ArchiveForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class InscriptionAdminController extends Controller
{
	/**
	* @Route("/admin/inscription/utilisateur/")
	* @Method({"GET", "POST"})
	*/
	public function utilisateurAction(Request $request)
	{
		$user = new User();
		return $this->renderUserAdminPage($request, $user);
	}

	/**
	* @Route("/admin/inscription/utilisateur/{id}/")
	* @Method({"GET", "POST"})
	*/
	public function utilisateurByIdAction($id, Request $request)
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
				'users' => $users,
				'form' => $form->createView(),
		]);
	}

	/**
	* @Route("/admin/inscription/archive/", name="admin_archive")
	* @Method({"GET", "POST"})
	*/
	public function archiveAction(Request $request){
		$base = new Base();
		$form = $this->createForm(ArchiveForm::class, $base);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			copy("http://licences.ffcorientation.fr/licencesFFCO.csv", "archive.csv");

			$db = $this->getDoctrine()->getManager()->getConnection();
			$sql = "SET foreign_key_checks = 0;
							LOAD DATA INFILE 'archive.csv'
								REPLACE
								INTO TABLE base
								FIELDS TERMINATED BY ';'
								ENCLOSED BY '\"'
								LINES TERMINATED BY '\r\n'
								IGNORE 1 LINES
								(@col1, @col2, @col3, @col4, @col5, @col6, @col7, @col8, @col9, @col10, @col11, @col12, @col13, @col14, @col15, @col16, @col17, @col18, @col19, @col20, @col21, @col22, @col23, @col24, @col25, @col26, @col27, @col28, @col29, @col30)
								SET id = @col1,
								puce = @col2,
								nom = @col3,
								prenom = @col4,
								ne = @col5,
								sexe = @col6,
								nom_club = @col8,
								ville = @col9,
								categorie = @col12;
							SET foreign_key_checks = 1;";
			$stmt = $db->prepare($sql);
			$stmt->execute();
			return $this->redirectToRoute('admin_archive');
		}

		return $this->render('admin/inscription/archive.html.twig', [
			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
			'form' => $form->createView(),
		]);
	}

  /**
	* Function to delete an user
	* @param User $user the user entity to delete into database
	* @return the redirect view
	*/
	private function delete(User $user)
	{
    if($user->getId() !== null){
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
