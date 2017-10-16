<?php

namespace Bundle\InscriptionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Entity\Course;
use Bundle\InscriptionBundle\Form\Course\CourseSelectType;
use Symfony\Component\HttpFoundation\Response;
use Bundle\CalendarBundle\Form\Inscrit\CollectionInscritType;

class InscriptionController extends Controller
{
    const MODE_PERSONNALISE = 1;
    const MODE_CLUB = 2;
    const MODE_LICENCIE = 3;
    const MODE_NON_LICENCIE = 4;

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

    /**
    * Permet de récupérer l'élément suivant du formulaire
    *
    * @param string $data nom du type de formulaire à récupérer
    *
    * @return le rendu de la nouvelle étape du formulaire
    */
    public function postCourseAction($data)
    {
        return $this->render('InscriptionBundle:Common:partials/' . $data . '.html.twig',
          array($data => true));
    }

    public function inscritAction($id)
    {
        $inscrits = $this->get('manager.inscrit')->getListeInscrit($id);
        $course = $this->get('manager.course')->get($id);

        return $this->render('InscriptionBundle:Consulter:partials/inscrit.html.twig',
          array('inscrits' => $inscrits, 'course' => $course));
    }

    public function downloadAction()
    {
        //TODO
    }

    public function formulaireAction($id, $mode)
    {
        $course = $this->get('manager.course')->get($id);

        switch ($mode) {
            case static::MODE_PERSONNALISE:
                $inscrits = $this->get('manager.inscrit')->getInscrit($id);
                $form = $this->createForm(CollectionInscritType::class, $inscrits, array('course' => $id));
                break;

            default:
                # code...
                break;
        }

        return $this->render('InscriptionBundle:Inscrire:partials/inscription.html.twig',
          array('course' => $course, 'form' => $form->createView()));
    }
}
