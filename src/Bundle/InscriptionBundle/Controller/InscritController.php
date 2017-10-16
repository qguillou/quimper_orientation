<?php

namespace Bundle\InscriptionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Entity\Course;
use Bundle\InscriptionBundle\Form\Course\CourseSelectType;
use Symfony\Component\HttpFoundation\Response;
use Bundle\CalendarBundle\Form\Inscrit\CollectionInscritType;
use Symfony\Component\HttpFoundation\Request;

class InscritController extends Controller
{
    public function unregisterAction(Request $request)
    {
        $course = $this->get('manager.inscrit')->unregister($request->get('id'));

        return $this->render('InscriptionBundle:Common:inscrit/table_liste_inscrit.html.twig', array('course' => $course, 'inscrits' => $course->getInscrits()));
    }

    public function registerAction(request $request, $id)
    {
        $inscrits = $this->get('manager.inscrit')->getInscrit($id);
        $form = $this->createForm(CollectionInscritType::class, $inscrits, array('course' => $id));
        $form->handleRequest($request);

        $course = $this->get('manager.inscrit')->register($id, $form);

        return $this->render('InscriptionBundle:Common:inscrit/table_liste_inscrit.html.twig', array('course' => $course, 'inscrits' => $course->getInscrits()));
    }
}
