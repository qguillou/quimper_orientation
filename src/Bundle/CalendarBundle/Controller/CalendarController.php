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

        $data = array();
        foreach ($courses as $course) {
            $data[date('Y-m-d', $course->getDate()->getTimestamp())] = array("url" => "/calendrier/" . $course->getId());
        }

        return $this->render('CalendarBundle:Calendar:calendar.html.twig',
            array(
                "courses" => $courses,
                "events" => json_encode($data)
            )
        );
    }

    public function courseAction(Request $request, $id)
    {
      $course = $this->get('manager.course')->get($id);

      $inscrits = $this->get('manager.inscrit')->getInscrit($course);
      $form = $this->createForm(CollectionInscritType::class, $inscrits, array('course' => $id));

      $prev = $this->get('manager.course')->getPrev($course);
      $next = $this->get('manager.course')->getNext($course);

      return $this->render('CalendarBundle:Course:course.html.twig',
            array(
                'course' => $course,
                'form' => $form->createView(),
                'next' => $next,
                'prev' => $prev
            )
      );
    }
}
