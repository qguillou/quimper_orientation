<?php

namespace Bundle\AdminBundle\Controller;

use Bundle\AdminBundle\Controller\DefaultAdminController;
use Entity\Contact;
use Form\Type\ContactType;

class AdminContactController extends DefaultAdminController
{
    public function indexAction()
    {
        $entities = $this->getManager()->getAll();

        return $this->render('AdminBundle:Contact:contact.html.twig', array('entities' => $entities));
    }

    protected function getFormClass()
    {
        return ContactType::class;
    }

    protected function getManager()
    {
        return $this->get('manager.contact');
    }

    protected function getEntityType()
    {
        return new Contact();
    }

    protected function getEntityName()
    {
        return 'contact';
    }

    protected function getTable()
    {
        $entities = $this->getManager()->getAll();

        return $this->renderView('AdminBundle:Contact:table_contact.html.twig', array('entities' => $entities));
    }

    protected function getForm($form)
    {
        return $this->render('AdminBundle:Contact:form_contact.html.twig',
            array('form' => $form->createView()));
    }
}
