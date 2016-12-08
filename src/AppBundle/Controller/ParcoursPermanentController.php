<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Carte\CarteType;
use AppBundle\Entity\Cartes;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class ParcoursPermanentController extends Controller
{
	/**
     * @Route("/parcours/")
     */
    public function parcours()
    {
				$em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Cartes');
        $cartes = $repository->findAll();
    		$session = $this->get('app.session');
				return $this->render('user/parcours/parcours.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
						'user' => $this->getUser(),
						'isConnected' => $session->isAuthenticated(),
            'isAdmin' => $session->isAdmin(),
            'cartes' => $cartes,
        ]);
    }

    /**
    * @Route("/parcours/{id}/")
    */
    public function getParcours($id)
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
        return $this->redirect('/files/cartes/'.$id.'/carte.pdf');
      }

      return $this->redirect('/files/cartes/'.$id.'/carte.pdf');
    }

    /**
    * @Route("/admin/parcours/")
    */
    public function adminParcours(Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $repository = $em->getRepository('AppBundle:Cartes');
      $cartes = $repository->findAll();
      $session = $this->get('app.session');

      $carte = new Cartes();
      $form = $this->createForm(CarteType::class, $carte);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $carte->setDateModification(new \DateTime());
        $carte->setNbTelechargement(0);
        $carte->setAlert(false);
        try {
          $em = $this->getDoctrine()->getManager();
          $em->persist($carte);
          $em->flush();
        }
        catch (UniqueConstraintViolationException $e){
          $this->get('session')->getFlashBag()->add(
            'error',
            'La carte '.$carte->getNom().' n\'a pas pu être créée, une erreur est survenue.'
          );
          return $this->render(
            'admin/parcours/parcours.html.twig',
            array('form' => $form->createView(),
            'user' => $this->getUser(),
            'isConnected' => $session->isAuthenticated(),
            'isAdmin' => $session->isAdmin(),
            'active' => 0,
            'cartes' => $cartes)
          );
        }

        $this->get('session')->getFlashBag()->add(
          'success',
          'La carte '.$carte->getNom().' a été créée.'
        );

        return $this->redirect('/admin/parcours/'.$carte->getId());
      }

      return $this->render('admin/parcours/parcours.html.twig', [
          'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
          'user' => $this->getUser(),
          'isConnected' => $session->isAuthenticated(),
          'isAdmin' => $session->isAdmin(),
          'cartes' => $cartes,
          'active' => 0,
          'form' => $form->createView(),
      ]);
    }

    /**
    * @Route("/admin/parcours/{id}/")
    */
    public function adminParcoursById($id, Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $repository = $em->getRepository('AppBundle:Cartes');
      $cartes = $repository->findAll();
      $session = $this->get('app.session');

      $carte = $repository->findOneBy(array('id' => $id));
      $form = $this->createForm(CarteType::class, $carte);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $carte->setDateModification(new \DateTime());
        $carte->setNbTelechargement(0);
        $carte->setAlert(false);
        try {
          $em = $this->getDoctrine()->getManager();
          $em->persist($carte);
          $em->flush();
        }
        catch (UniqueConstraintViolationException $e){
          $this->get('session')->getFlashBag()->add(
            'error',
            'La carte '.$carte->getNom().' n\'a pas pu être modifiée, une erreur est survenue.'
          );
          return $this->render(
            'admin/parcours/parcours.html.twig',
            array('form' => $form->createView(),
            'user' => $this->getUser(),
            'isConnected' => $session->isAuthenticated(),
            'isAdmin' => $session->isAdmin(),
            'active' => $id,
            'cartes' => $cartes)
          );
        }

        $this->get('session')->getFlashBag()->add(
          'success',
          'La carte '.$carte->getNom().' a été modifiée.'
        );
        return $this->redirect('/admin/parcours/'.$id);
      }

      return $this->render('admin/parcours/parcours.html.twig', [
          'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
          'user' => $this->getUser(),
          'isConnected' => $session->isAuthenticated(),
          'isAdmin' => $session->isAdmin(),
          'cartes' => $cartes,
          'active' => $id,
          'form' => $form->createView(),
      ]);
    }

    /**
    *@Route("/admin/parcours/delete/{id}/")
    */
    public function deleteParcours($id)
    {
      $em = $this->getDoctrine()->getManager();
      $repository = $em->getRepository('AppBundle:Cartes');
      $carte = $repository->findOneBy(array('id' => $id));
      $em->remove($carte);
      $em->flush();

      $this->get('session')->getFlashBag()->add(
        'success',
        'La carte '.$carte->getNom().' a été supprimée.'
      );

      return $this->redirect('/admin/parcours/');
    }
}
