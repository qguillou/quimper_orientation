<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class InscriptionController extends Controller
{
	/**
     * @Route("/inscription/")
     */
    public function inscription()
    {
        return $this->render('user/inscription/inscription.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        	'isConnected' => false,
        ]);
    }

    /**
     * @Route("/inscription/consultation/")
     */
    public function consultation()
    {
        return $this->render('user/inscription/consultation.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'isConnected' => false,
        ]);
    }

    /**
     * @Route("/inscription/inscrire/")
     */
    public function inscrire()
    {
        return $this->render('user/inscription/inscrire.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'isConnected' => false,
        ]);
    }

    /**
     * @Route("/inscription/modification/")
     */
    public function modification()
    {
        return $this->render('user/inscription/modification.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'isConnected' => false,
        ]);
    }

    /**
     * @Route("/inscription/recuperation/")
     */
    public function recuperation()
    {
        return $this->render('user/inscription/recuperation.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'isConnected' => false,
        ]);
    }
}
