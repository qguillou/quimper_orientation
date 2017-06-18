<?php

namespace Bundle\ClubBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
        $licences = $this->get('manager.tarif')->getAll();

        return $this->render('ClubBundle:Club:rejoindre.html.twig',
          array("licences" => $licences));
    }

    public function contactAction()
    {
        $contacts = $this->get('manager.contact')->getDisplayContact();

        return $this->render('ClubBundle:Club:contact.html.twig',
          array("contacts" => $contacts));
    }
}
