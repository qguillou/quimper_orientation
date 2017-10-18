<?php

namespace Bundle\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
        $courses = $this->get('manager.course')->getCalendar();

        $data = array();
        foreach ($courses as $course) {
            $data[date('Y-m-d', $course->getDate()->getTimestamp())] = array("url" => "/calendrier/" . $course->getId());
        }

        return $this->render('HomeBundle:Home:home.html.twig',
            array(
                "events" => json_encode($data)
            )
        );
    }

    public function aboutAction()
    {
        return $this->render('HomeBundle:Home:about.html.twig');
    }

    public function helpAction()
    {
      return $this->render('HomeBundle:Home:help.html.twig');
    }
}
