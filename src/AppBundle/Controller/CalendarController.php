<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CalendarController extends Controller
{
	/**
     * @Route("/calendrier/")
     */
    public function calendar()
    {
				$session = $this->get('app.session');
				return $this->render('user/calendar/calendar.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
						'user' => $this->getUser(),
						'isConnected' => $session->isAuthenticated(),
            'isAdmin' => $session->isAdmin(),
        ]);
    }
}
