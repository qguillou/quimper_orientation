<?php

namespace Bundle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Entity\Course;
use Bundle\AdminBundle\Form\Course\CourseType;

class AdminCourseController extends Controller
{
    public function indexAction()
    {
        $courses = $this->get('manager.course')->getAll(array('date' => 'DESC'));

        return $this->render('AdminBundle:Course:course.html.twig',
            array('courses' => $courses));
    }

    public function addAction(Request $request)
    {
        if ($request->request->get('course')['id'] != "0") {
            $course = $this->get('manager.course')->get($request->request->get('course')['id']);
            $course->setDateModification(new \DateTime('now'));
            $course->setUserModification($this->get('security.token_storage')->getToken()->getUser());
        } else {
            $course = new Course();
            $course->setDateCreation(new \DateTime('now'));
            $course->setDateModification(new \DateTime('now'));
            $course->setUserCreation($this->get('security.token_storage')->getToken()->getUser());
            $course->setUserModification($this->get('security.token_storage')->getToken()->getUser());
        }

        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('manager.course')->save($course);
        }

        $courses = $this->get('manager.course')->getAll(array('date' => 'DESC'));
        $table = $this->renderView('AdminBundle:Course:table_course.html.twig',
            array('courses' => $courses));
        $messages = $this->renderView('::Message/message.html.twig');

        return new JsonResponse(array(
            'table' => $table,
            'messages' => $messages
        ));
    }

    public function deleteAction(Request $request)
    {
        $this->get('manager.course')->delete($request->get('id'));

        $courses = $this->get('manager.course')->getAll(array('date' => 'DESC'));
        $table = $this->renderView('AdminBundle:Course:table_course.html.twig',
            array('courses' => $courses));
        $messages = $this->renderView('::Message/message.html.twig');

        return new JsonResponse(array(
            'table' => $table,
            'messages' => $messages
        ));
    }

    public function formAction(Request $request)
    {
        if ($request->get('id') != 0) {
            $course = $this->get('manager.course')->get($request->get('id'));
        } else {
            $course = new Course();
            $course->setId(0);
        }

        $form = $this->createForm(CourseType::class, $course);

        return $this->render('AdminBundle:Course:form_course.html.twig',
            array('form' => $form->createView()));
    }
}
