<?php

namespace Bundle\InscriptionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InscriptionController extends Controller
{
    public function inscrireAction()
    {
        return $this->render('InscriptionBundle::inscrire.html.twig');
    }

    public function consulterAction()
    {
        return $this->render('InscriptionBundle::consulter.html.twig');
    }

    public function recuperationAction()
    {
        return $this->render('InscriptionBundle::recuperation.html.twig');
    }
}
