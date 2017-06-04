<?php

namespace Bundle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Entity\Actualite;
use Bundle\AdminBundle\Form\Actualite\ActualiteType;

class AdminActualiteController extends Controller
{
    public function indexAction()
    {
        $actualites = $this->get('manager.admin_actualite')->getAll();

        return $this->render('AdminBundle:Actualite:actualite.html.twig',
            array('actualites' => $actualites));
    }

    public function addAction(Request $request)
    {
        if ($request->request->get('actualite')['id'] != "0") {
            $actualite = $this->get('manager.admin_actualite')->get($request->request->get('actualite')['id']);
        } else {
            $actualite = new Actualite();
        }

        $form = $this->createForm(ActualiteType::class, $actualite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('manager.admin_actualite')->save($actualite);
        }

        $actualites = $this->get('manager.admin_actualite')->getAll();

        return $this->render('AdminBundle:Actualite:table_actualite.html.twig',
            array('actualites' => $actualites));
    }

    public function deleteAction(Request $request)
    {
        $this->get('manager.admin_actualite')->delete($request->get('id'));

        $actualites = $this->get('manager.admin_actualite')->getAll();

        return $this->render('AdminBundle:Actualite:table_actualite.html.twig',
            array('actualites' => $actualites));
    }

    public function formAction(Request $request)
    {
        if ($request->get('id') != 0) {
            $actualite = $this->get('manager.admin_actualite')->get($request->get('id'));
            $actualite->setDateModification(new \DateTime('now'));
        } else {
            $actualite = new Actualite();
            $actualite->setId(0);
            $actualite->setDateModification(new \DateTime('now'));
            $actualite->setDateCreation(new \DateTime('now'));
        }

        $form = $this->createForm(ActualiteType::class, $actualite);

        return $this->render('AdminBundle:Actualite:form_actualite.html.twig',
            array('form' => $form->createView()));
    }
}
