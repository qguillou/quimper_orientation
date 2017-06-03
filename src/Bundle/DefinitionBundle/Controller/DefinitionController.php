<?php

namespace Bundle\DefinitionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefinitionController extends Controller
{
    public function definitionAction()
    {
        $definitions = array();
        
        return $this->render('DefinitionBundle:Definition:definition.html.twig',
            array('definitons' => $definitions));
    }
}
