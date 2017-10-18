<?php

namespace Bundle\AccountBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AccountController extends Controller
{
    public function parameterAction()
    {
        return $this->render('AccountBundle::parameter.html.twig');
    }

    public function calendarAction()
    {
        $courses = $this->get('manager.course')->getUserCalendar($this->get('security.token_storage')->getToken()->getUser());

        $data = array();
        foreach ($courses as $course) {
            $data[date('Y-m-d', $course->getDate()->getTimestamp())] = array("url" => "/calendrier/" . $course->getId());
        }

        return $this->render('AccountBundle::calendar.html.twig',
            array(
                "courses" => $courses,
                "events" => json_encode($data)
            )
        );
    }

}
