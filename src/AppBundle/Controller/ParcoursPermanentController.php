<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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
    * @Route("/parcours/{id}")
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
}
