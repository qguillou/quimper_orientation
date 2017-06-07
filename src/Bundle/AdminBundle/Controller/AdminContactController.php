<?php

namespace Bundle\AdminBundle\Controller;

use Bundle\AdminBundle\Controller\DefaultAdminController;
use Entity\Contact;
use Bundle\AdminBundle\Form\Contact\ContactType;

class AdminContactController extends DefaultAdminController
{
    public function indexAction()
    {
        $entities = $this->getManager()->getAll();

        return $this->render('AdminBundle:Contact:contact.html.twig', array('entities' => $entities));
    }

    public function getFormClass()
    {
        return ContactType::class;
    }

    public function getManager()
    {
        return $this->get('manager.contact');
    }

    public function getEntityType()
    {
        return new Contact();
    }

    public function getEntityName()
    {
        return 'contact';
    }

    public function getTable()
    {
        $entities = $this->getManager()->getAll();

        return $this->renderView('AdminBundle:Contact:table_contact.html.twig', array('entities' => $entities));
    }

    public function getForm($form)
    {
        return $this->render('AdminBundle:Contact:form_contact.html.twig',
            array('form' => $form->createView()));
    }
}