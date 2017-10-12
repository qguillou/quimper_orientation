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
        return $this->render('AccountBundle::calendar.html.twig');
    }

}
