<?php

namespace AppBundle\Controller\User;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
				$repository = $em->getRepository('AppBundle:Course');
        $courses = $repository->findAll();
        return $this->render('user/default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'courses' => $courses,
        ]);
    }

    /**
     * @Route("/about")
     */
    public function aboutAction(Request $request)
    {
        return $this->render('user/default/about.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
}
