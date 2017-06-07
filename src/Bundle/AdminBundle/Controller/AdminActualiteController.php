<?php

namespace Bundle\AdminBundle\Controller;

use Bundle\AdminBundle\Controller\DefaultAdminController;
use Entity\Actualite;
use Form\Type\ActualiteType;

class AdminActualiteController extends DefaultAdminController
{
    public function indexAction()
    {
        $entities = $this->getManager()->getAll();

        return $this->render('AdminBundle:Actualite:actualite.html.twig', array('entities' => $entities));
    }

    protected function getFormClass()
    {
        return ActualiteType::class;
    }

    protected function getManager()
    {
        return $this->get('manager.actualite');
    }

    protected function getEntityType()
    {
        return new Actualite();
    }

    protected function getEntityName()
    {
        return 'actualite';
    }

    protected function getTable()
    {
        $entities = $this->getManager()->getAll();

        return $this->renderView('AdminBundle:Actualite:table_actualite.html.twig', array('entities' => $entities));
    }

    protected function getForm($form)
    {
        return $this->render('AdminBundle:Actualite:form_actualite.html.twig',
            array('form' => $form->createView()));
    }
}
