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
        return $this->render('user/default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'user' => $this->getUser(),
            'isConnected' => $this->isAuthenticated(),
            'isAdmin' => $this->isAdmin(),
        ]);
    }

    /**
     * @Route("/about")
     */
    public function aboutAction(Request $request)
    {
        return $this->render('user/default/about.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'user' => $this->getUser(),
            'isConnected' => $this->isAuthenticated(),
            'isAdmin' => $this->isAdmin(),
        ]);
    }

    private function isAuthenticated(){
      return $this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED');
    }

    private function isAdmin(){
      if(!$this->isAuthenticated())
        return false;
      $user = $this->getUser();
      $roles = $user->getRoles();
      return in_array("ROLE_ADMIN", $roles);
    }
}
