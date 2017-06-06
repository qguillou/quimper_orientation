<?php

namespace Bundle\AdminBundle\Controller;

use Bundle\AdminBundle\Controller\DefaultAdminController;
use Entity\Actualite;
use Bundle\AdminBundle\Form\Actualite\ActualiteType;

class AdminActualiteController extends DefaultAdminController
{
    public function indexAction()
    {
        $entities = $this->getManager()->getAll();

        return $this->render('AdminBundle:Actualite:actualite.html.twig', array('entities' => $entities));
    }

    public function getFormClass()
    {
        return ActualiteType::class;
    }

    public function getManager()
    {
        return $this->get('manager.actualite');
    }

    public function getEntityType()
    {
        return new Actualite();
    }

    public function getEntityName()
    {
        return 'actualite';
    }

    public function getTable()
    {
        $entities = $this->getManager()->getAll();

        return $this->renderView('AdminBundle:Actualite:table_actualite.html.twig', array('entities' => $entities));
    }

    public function getForm($form)
    {
        return $this->render('AdminBundle:Actualite:form_actualite.html.twig',
            array('form' => $form->createView()));
    }
}
