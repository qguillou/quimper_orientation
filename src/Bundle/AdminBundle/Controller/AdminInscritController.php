<?php

namespace Bundle\AdminBundle\Controller;

use Bundle\AdminBundle\Controller\DefaultAdminController;
use Entity\Inscrit;
use Bundle\AdminBundle\Form\Inscrit\InscritType;

class AdminInscritController extends DefaultAdminController
{
    public function indexAction()
    {
        $entities = $this->getManager()->getAll();

        return $this->render('AdminBundle:Inscrit:inscrit.html.twig', array('entities' => $entities));
    }

    public function getFormClass()
    {
        return InscritType::class;
    }

    public function getManager()
    {
        return $this->get('manager.inscrit');
    }

    public function getEntityType()
    {
        return new Inscrit();
    }

    public function getEntityName()
    {
        return 'inscrit';
    }

    public function getTable()
    {
        $entities = $this->getManager()->getAll();

        return $this->renderView('AdminBundle:Inscrit:table_inscrit.html.twig', array('entities' => $entities));
    }

    public function getForm($form)
    {
        return $this->render('AdminBundle:Inscrit:form_inscrit.html.twig',
            array('form' => $form->createView()));
    }
}
