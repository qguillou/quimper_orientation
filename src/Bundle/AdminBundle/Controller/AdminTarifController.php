<?php

namespace Bundle\AdminBundle\Controller;

use Bundle\AdminBundle\Controller\DefaultAdminController;
use Entity\Tarif;
use Bundle\AdminBundle\Form\Tarif\TarifType;

class AdminTarifController extends DefaultAdminController
{
    public function indexAction()
    {
        $entities = $this->getManager()->getAll();

        return $this->render('AdminBundle:Tarif:tarif.html.twig', array('entities' => $entities));
    }

    public function getFormClass()
    {
        return TarifType::class;
    }

    public function getManager()
    {
        return $this->get('manager.tarif');
    }

    public function getEntityType()
    {
        return new Tarif();
    }

    public function getEntityName()
    {
        return 'tarif';
    }

    public function getTable()
    {
        $entities = $this->getManager()->getAll();

        return $this->renderView('AdminBundle:Tarif:table_tarif.html.twig', array('entities' => $entities));
    }

    public function getForm($form)
    {
        return $this->render('AdminBundle:Tarif:form_tarif.html.twig',
            array('form' => $form->createView()));
    }
}
