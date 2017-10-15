<?php

namespace Bundle\CalendarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Bundle\CalendarBundle\Form\Inscrit\CollectionInscritType;
use Symfony\Component\HttpFoundation\Request;

class CalendarController extends Controller
{
    public function calendarAction()
    {
        $courses = $this->get('manager.course')->getCalendar();

        return $this->render('CalendarBundle:Calendar:calendar.html.twig',
          array("courses" => $courses));
    }

    public function courseAction(Request $request, $id)
    {
      $course = $this->get('manager.course')->get($id);

      $inscrits = $this->get('manager.inscrit')->getInscrit($course);
      $form = $this->createForm(CollectionInscritType::class, $inscrits, array('course' => $id));

      return $this->render('CalendarBundle:Course:course.html.twig',
        array('course' => $course,
              'form' => $form->createView()
            ));
    }

    public function unregisterAction(Request $request)
    {
        $course = $this->get('manager.inscrit')->unregister($request->get('id'));

        return $this->render('CalendarBundle:Course:partials/inscrits.html.twig',
          array('course' => $course));
    }

    public function registerAction(request $request, $id)
    {
      $inscrits = $this->get('manager.inscrit')->getInscrit($id);
      $form = $this->createForm(CollectionInscritType::class, $inscrits, array('course' => $id));
      $form->handleRequest($request);

      //TODO trouver un moyen de savoir quelle ligne a été cochée

      $course = $this->get('manager.inscrit')->register($id, $form);

      return $this->render('CalendarBundle:Course:partials/inscrits.html.twig',
        array('course' => $course));
    }
}
