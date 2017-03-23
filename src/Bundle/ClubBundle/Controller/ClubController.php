<?php

namespace Bundle\ClubBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ClubController extends Controller
{
    public function presentationAction()
    {
        return $this->render('ClubBundle:Club:presentation.html.twig');
    }

    public function ecoleAction()
    {
        return $this->render('ClubBundle:Club:ecole.html.twig');
    }

    public function rejoindreAction()
    {
        $licences = $this->get('manager.tarif')->getTarif();

        return $this->render('ClubBundle:Club:rejoindre.html.twig',
          array("licences" => $licences));
    }

    public function contactAction()
    {
        $contacts = $this->get('manager.contact')->getContact();

        return $this->render('ClubBundle:Club:contact.html.twig',
          array("contacts" => $contacts));
    }
}
