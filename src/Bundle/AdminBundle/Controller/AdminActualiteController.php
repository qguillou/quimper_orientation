<?php

namespace Bundle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminActualiteController extends Controller
{
    public function indexAction()
    {
        $actualites = $this->get('manager.admin_actualite')->getAll();

        return $this->render('AdminBundle:Actualite:actualite.html.twig',
            array('actualites' => $actualites));
    }

    public function deleteAction(Request $request)
    {
      $course = $this->get('manager.admin_actualite')->delete($request->get('id'));

      $actualites = $this->get('manager.admin_actualite')->getAll();

      return $this->render('AdminBundle:Actualite:table_actualite.html.twig',
        array('actualites' => $actualites));
    }
}
