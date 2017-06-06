<?php

namespace Bundle\AdminBundle\Controller;

use Bundle\AdminBundle\Controller\DefaultAdminController;
use Entity\Role;
use Bundle\AdminBundle\Form\Role\RoleType;

class AdminRoleController extends DefaultAdminController
{
    public function indexAction()
    {
        $entities = $this->getManager()->getAll();

        return $this->render('AdminBundle:Role:role.html.twig', array('entities' => $entities));
    }

    public function getFormClass()
    {
        return RoleType::class;
    }

    public function getManager()
    {
        return $this->get('manager.role');
    }

    public function getEntityType()
    {
        return new Role();
    }

    public function getEntityName()
    {
        return 'role';
    }

    public function getTable()
    {
        $entities = $this->getManager()->getAll();

        return $this->renderView('AdminBundle:Role:table_role.html.twig', array('entities' => $entities));
    }

    public function getForm($form)
    {
        return $this->render('AdminBundle:Role:form_role.html.twig',
            array('form' => $form->createView()));
    }
}
