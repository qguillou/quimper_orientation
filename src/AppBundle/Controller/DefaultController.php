<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Course;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $session = $this->get('app.session');
        $em = $this->getDoctrine()->getManager();
				$repository = $em->getRepository('AppBundle:Course');
        $courses = $repository->findAll();
        return $this->render('user/default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'user' => $this->getUser(),
            'isConnected' => $session->isAuthenticated(),
            'isAdmin' => $session->isAdmin(),
            'courses' => $courses,
        ]);
    }

    /**
     * @Route("/about")
     */
    public function aboutAction(Request $request)
    {
        $session = $this->get('app.session');
        return $this->render('user/default/about.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'user' => $this->getUser(),
            'isConnected' => $session->isAuthenticated(),
            'isAdmin' => $session->isAdmin(),
        ]);
    }
}
