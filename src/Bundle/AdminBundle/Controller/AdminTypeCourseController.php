<?php

namespace Bundle\AdminBundle\Controller;

use Bundle\AdminBundle\Controller\DefaultAdminController;
use Entity\Type;
use Bundle\AdminBundle\Form\TypeCourse\TypeCourseType;

class AdminTypeCourseController extends DefaultAdminController
{
    public function indexAction()
    {
        $types = $this->get('manager.type')->getAll(array('nom' => 'ASC'));

        return $this->render('AdminBundle:TypeCourse:type.html.twig', array('types' => $types));
    }

    public function getFormClass()
    {
        return TypeCourseType::class;
    }

    public function getManager()
    {
        return $this->get('manager.type');
    }

    public function getEntityType()
    {
        return new TypeCourse();
    }

    public function getEntityName()
    {
        return 'type_course';
    }

    public function getTable()
    {
        $types = $this->get('manager.type')->getAll(array('nom' => 'ASC'));

        return $this->renderView('AdminBundle:TypeCourse:table_type.html.twig', array('types' => $types));
    }

    public function getForm($form)
    {
        return $this->render('AdminBundle:TypeCourse:form_type.html.twig',
            array('form' => $form->createView()));
    }
}
