<?php

namespace Bundle\AdminBundle\Controller;

use Bundle\AdminBundle\Controller\DefaultAdminController;
use Entity\Carte;
use Bundle\AdminBundle\Form\Carte\CarteType;

class AdminCarteController extends DefaultAdminController
{
    public function indexAction()
    {
        $entities = $this->getManager()->getAll();

        return $this->render('AdminBundle:Carte:carte.html.twig', array('entities' => $entities));
    }

    protected function getFormClass()
    {
        return CarteType::class;
    }

    protected function getManager()
    {
        return $this->get('manager.carte');
    }

    protected function getEntityType()
    {
        return new Carte();
    }

    protected function getEntityName()
    {
        return 'carte';
    }

    protected function getTable()
    {
        $entities = $this->getManager()->getAll();

        return $this->renderView('AdminBundle:Carte:table_carte.html.twig', array('entities' => $entities));
    }

    protected function getForm($form)
    {
        return $this->render('AdminBundle:Carte:form_carte.html.twig',
            array('form' => $form->createView()));
    }
}
