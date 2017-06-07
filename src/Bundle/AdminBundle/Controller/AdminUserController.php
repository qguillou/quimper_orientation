<?php

namespace Bundle\AdminBundle\Controller;

use Bundle\AdminBundle\Controller\DefaultAdminController;
use Entity\User;
use Bundle\AdminBundle\Form\User\UserType;

class AdminUserController extends DefaultAdminController
{
    public function indexAction()
    {
        $entities = $this->getManager()->getAll();

        return $this->render('AdminBundle:User:user.html.twig', array('entities' => $entities));
    }

    protected function getFormClass()
    {
        return UserType::class;
    }

    protected function getManager()
    {
        return $this->get('manager.user');
    }

    protected function getEntityType()
    {
        return new User();
    }

    protected function getEntityName()
    {
        return 'user';
    }

    protected function getTable()
    {
        $entities = $this->getManager()->getAll();

        return $this->renderView('AdminBundle:User:table_user.html.twig', array('entities' => $entities));
    }

    protected function getForm($form)
    {
        return $this->render('AdminBundle:User:form_user.html.twig',
            array('form' => $form->createView()));
    }
}
