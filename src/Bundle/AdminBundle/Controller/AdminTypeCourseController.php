<?php

namespace Bundle\AdminBundle\Controller;

use Bundle\AdminBundle\Controller\DefaultAdminController;
use Entity\Type;
use Form\Type\TypeType;

class AdminTypeCourseController extends DefaultAdminController
{
    public function indexAction()
    {
        $entities = $this->getManager()->getAll(array('nom' => 'ASC'));

        return $this->render('AdminBundle:TypeCourse:type.html.twig', array('entities' => $entities));
    }

    protected function getFormClass()
    {
        return TypeType::class;
    }

    protected function getManager()
    {
        return $this->get('manager.type');
    }

    protected function getEntityType()
    {
        return new Type();
    }

    protected function getEntityName()
    {
        return 'type_course';
    }

    protected function getTable()
    {
        $entities = $this->getManager()->getAll(array('nom' => 'ASC'));

        return $this->renderView('AdminBundle:TypeCourse:table_type.html.twig', array('entities' => $entities));
    }

    protected function getForm($form)
    {
        return $this->render('AdminBundle:TypeCourse:form_type.html.twig',
            array('form' => $form->createView()));
    }
}
