<?php

namespace Bundle\AdminBundle\Controller;

use Bundle\AdminBundle\Controller\DefaultAdminController;
use Entity\Role;
use Form\RoleType;

class AdminRoleController extends DefaultAdminController
{
    public function indexAction()
    {
        $entities = $this->getManager()->getAll();

        return $this->render('AdminBundle:Role:role.html.twig', array('entities' => $entities));
    }

    protected function getFormClass()
    {
        return RoleType::class;
    }

    protected function getManager()
    {
        return $this->get('manager.role');
    }

    protected function getEntityType()
    {
        return new Role();
    }

    protected function getEntityName()
    {
        return 'role';
    }

    protected function getTable()
    {
        $entities = $this->getManager()->getAll();

        return $this->renderView('AdminBundle:Role:table_role.html.twig', array('entities' => $entities));
    }

    protected function getForm($form)
    {
        return $this->render('AdminBundle:Role:form_role.html.twig',
            array('form' => $form->createView()));
    }
}
