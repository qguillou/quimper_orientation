<?php

namespace Bundle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function indexAction()
    {
        $admins = $this->get('manager.admin')->getAdministrators();

        return $this->render('AdminBundle:Admin:index.html.twig',
            array('admins' => $admins));
    }
}
