<?php

namespace Bundle\InscriptionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Entity\Course;
use Bundle\InscriptionBundle\Form\Course\CourseSelectType;

class InscriptionController extends Controller
{
    public function inscrireAction()
    {
        $course = new Course();
        $form = $this->createForm(CourseSelectType::class, $course);

        return $this->render('InscriptionBundle:Inscrire:inscrire.html.twig',
          array('course' => $form->createView()));
    }

    public function consulterAction()
    {
        $course = new Course();
        $form = $this->createForm(CourseSelectType::class, $course);

        return $this->render('InscriptionBundle:Consulter:consulter.html.twig',
          array('course' => $form->createView()));
    }

    public function recuperationAction()
    {
        $course = new Course();
        $form = $this->createForm(CourseSelectType::class, $course);

        return $this->render('InscriptionBundle:Recuperer:recuperation.html.twig',
          array('course' => $form->createView()));    }

    public function modeAction()
    {
        return $this->render('InscriptionBundle:Inscrire:partials/mode.html.twig',
          array('mode' => true));
    }

    public function typeAction()
    {
        return $this->render('InscriptionBundle:Recuperer:partials/type.html.twig',
          array('type' => true));
    }

    public function inscritAction($id)
    {
        $inscrits = $this->get('manager.inscrit')->getListeInscrit($id);
        $course = $this->get('manager.course')->get($id);

        return $this->render('InscriptionBundle:Consulter:partials/inscrit.html.twig',
          array('inscrits' => $inscrits, 'course' => $course));
    }
}
