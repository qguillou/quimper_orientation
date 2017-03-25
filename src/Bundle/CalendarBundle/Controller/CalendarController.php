<?php

namespace Bundle\CalendarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Bundle\CalendarBundle\Form\Inscrit\CollectionInscritType;
use Symfony\Component\HttpFoundation\Request;

class CalendarController extends Controller
{
    public function calendarAction()
    {
        $courses = $this->get('manager.course')->getCourse();

        return $this->render('CalendarBundle:Calendar:calendar.html.twig',
          array("courses" => $courses));
    }

    public function courseAction(Request $request, $id)
    {
      $course = $this->get('manager.course')->getCourseById($id);

      $inscrits = $this->get('manager.inscrit')->getInscrit($course);
      $form = $this->createForm(CollectionInscritType::class, $inscrits);

      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        $inscrits = $this->get('manager.inscrit')->saveInscrit($request, $form->getData()['inscrits']);
			}

      return $this->render('CalendarBundle:Course:course.html.twig',
        array('course' => $course,
              'form' => $form->createView()
            ));
    }
}
