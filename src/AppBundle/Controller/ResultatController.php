<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ResultatController extends Controller
{
	/**
     * @Route("/resultat/")
     */
    public function results()
    {
        return $this->render('user/results/results.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        	'isConnected' => false,
        ]);
    }
}
