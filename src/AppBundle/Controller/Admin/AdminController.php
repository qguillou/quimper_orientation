<?php

namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AdminController extends Controller
{
	   /**
     * @Route("/admin/")
     */
    public function adminAction()
    {
				$session = $this->get('app.session');
				$em = $this->getDoctrine()->getManager();
				$repository = $em->getRepository('AppBundle:User');
				$users = $repository->findAdminUser();

				return $this->render('admin/default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
						'user' => $this->getUser(),
            'isAdmin' => $session->isAdmin(),
						'admins' => $users,
        ]);
    }
}
