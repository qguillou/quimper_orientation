<?php

namespace Bundle\AdminBundle\Controller;

use Bundle\AdminBundle\Controller\DefaultAdminController;
use Entity\Course;
use Bundle\AdminBundle\Form\Course\CourseType;

class AdminCourseController extends DefaultAdminController
{
    public function indexAction()
    {
        $entities = $this->getManager()->getAll(array('date' => 'DESC'));

        return $this->render('AdminBundle:Course:course.html.twig', array('entities' => $entities));
    }

    public function getFormClass()
    {
        return CourseType::class;
    }

    public function getManager()
    {
        return $this->get('manager.course');
    }

    public function getEntityType()
    {
        return new Course();
    }

    public function getEntityName()
    {
        return 'course';
    }

    public function getTable()
    {
        $entities = $this->getManager()->getAll(array('date' => 'DESC'));

        return $this->renderView('AdminBundle:Course:table_course.html.twig', array('entities' => $entities));
    }

    public function getForm($form)
    {
        return $this->render('AdminBundle:Course:form_course.html.twig',
            array('form' => $form->createView()));
    }
}
