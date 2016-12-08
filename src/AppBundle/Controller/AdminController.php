<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\User;

class AdminController extends Controller
{
	   /**
     * @Route("/admin/")
     */
    public function admin()
    {
				$session = $this->get('app.session');
				$em = $this->getDoctrine()->getManager();
				$repository = $em->getRepository('AppBundle:User');
				$users = $repository->findAdminUser();

				return $this->render('admin/default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
						'user' => $this->getUser(),
						'isConnected' => $session->isAuthenticated(),
            'isAdmin' => $session->isAdmin(),
						'admins' => $users,
        ]);
    }
}
