<?php

namespace Bundle\ParcoursBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ParcoursController extends Controller
{
    public function parcoursAction()
    {
        $cartes = $this->get('manager.carte')->getCarte();

        return $this->render('ParcoursBundle:Parcours:parcours.html.twig',
          array("cartes" => $cartes));
    }
}
