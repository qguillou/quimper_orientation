<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Controller\DefaultController;

class ClubController extends Controller
{

		/**
     * @Route("/club/presentation/")
     */
    public function presentationAction()
    {
				return $this->render('user/club/presentation.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'isConnected' => false,
        ]);
    }

    /**
     * @Route("/club/rejoindre/")
     */
    public function rejoindreAction()
    {
        return $this->render('user/club/rejoindre.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'isConnected' => false,
        ]);
    }

    /**
     * @Route("/club/ecole/")
     */
    public function ecoleAction()
    {
        return $this->render('user/club/ecole.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'isConnected' => false,
        ]);
    }

    /**
     * @Route("/club/contact/")
     */
    public function contactAction()
    {
        return $this->render('user/club/contact.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'isConnected' => false,
        ]);
    }
}
