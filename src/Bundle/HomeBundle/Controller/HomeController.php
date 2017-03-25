<?php

namespace Bundle\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
        return $this->render('HomeBundle:Home:home.html.twig');
    }

    public function aboutAction()
    {
        return $this->render('HomeBundle:Home:about.html.twig');
    }

    public function helpAction()
    {
      return $this->render('HomeBundle:Home:help.html.twig');
    }
}
