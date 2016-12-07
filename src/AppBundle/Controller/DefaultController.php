<?php

namespace AppBundle\Controller;

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
        $session = $this->get('app.session');
        return $this->render('user/default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'user' => $this->getUser(),
            'isConnected' => $session->isAuthenticated(),
            'isAdmin' => $session->isAdmin(),
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
