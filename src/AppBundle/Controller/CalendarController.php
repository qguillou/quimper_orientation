<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Course;

class CalendarController extends Controller
{
		/**
     * @Route("/calendrier/")
     */
    public function calendar()
    {
				$session = $this->get('app.session');
				$em = $this->getDoctrine()->getManager();
				$repository = $em->getRepository('AppBundle:Course');
        $courses = $repository->findAll();
				return $this->render('user/calendar/calendar.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
						'user' => $this->getUser(),
						'isConnected' => $session->isAuthenticated(),
            'isAdmin' => $session->isAdmin(),
						'courses' => $courses,
        ]);
    }

		/**
		 *@Route("/calendrier/{id}/")
		 */
		 public function course()
		 {
			 $session = $this->get('app.session');
			 return $this->render('user/calendar/course.html.twig', [
					 'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
					 'user' => $this->getUser(),
					 'isConnected' => $session->isAuthenticated(),
					 'isAdmin' => $session->isAdmin(),
			 ]);
		 }
}
