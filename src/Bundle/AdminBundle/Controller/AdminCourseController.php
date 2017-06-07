<?php

namespace Bundle\AdminBundle\Controller;

use Bundle\AdminBundle\Controller\DefaultAdminController;
use Entity\Course;
use Form\Type\CourseType;

class AdminCourseController extends DefaultAdminController
{
    public function indexAction()
    {
        $entities = $this->getManager()->getAll(array('date' => 'DESC'));

        return $this->render('AdminBundle:Course:course.html.twig', array('entities' => $entities));
    }

    protected function getFormClass()
    {
        return CourseType::class;
    }

    protected function getManager()
    {
        return $this->get('manager.course');
    }

    protected function getEntityType()
    {
        return new Course();
    }

    protected function getEntityName()
    {
        return 'course';
    }

    protected function getTable()
    {
        $entities = $this->getManager()->getAll(array('date' => 'DESC'));

        return $this->renderView('AdminBundle:Course:table_course.html.twig', array('entities' => $entities));
    }

    protected function getForm($form)
    {
        return $this->render('AdminBundle:Course:form_course.html.twig',
            array('form' => $form->createView()));
    }
}
