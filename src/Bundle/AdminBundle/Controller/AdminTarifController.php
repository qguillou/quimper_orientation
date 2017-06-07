<?php

namespace Bundle\AdminBundle\Controller;

use Bundle\AdminBundle\Controller\DefaultAdminController;
use Entity\Tarif;
use Form\Type\TarifType;

class AdminTarifController extends DefaultAdminController
{
    public function indexAction()
    {
        $entities = $this->getManager()->getAll();

        return $this->render('AdminBundle:Tarif:tarif.html.twig', array('entities' => $entities));
    }

    protected function getFormClass()
    {
        return TarifType::class;
    }

    protected function getManager()
    {
        return $this->get('manager.tarif');
    }

    protected function getEntityType()
    {
        return new Tarif();
    }

    protected function getEntityName()
    {
        return 'tarif';
    }

    protected function getTable()
    {
        $entities = $this->getManager()->getAll();

        return $this->renderView('AdminBundle:Tarif:table_tarif.html.twig', array('entities' => $entities));
    }

    protected function getForm($form)
    {
        return $this->render('AdminBundle:Tarif:form_tarif.html.twig',
            array('form' => $form->createView()));
    }
}
