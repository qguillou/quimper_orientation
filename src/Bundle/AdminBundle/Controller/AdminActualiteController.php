<?php

namespace Bundle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
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
            $actualite->setDateModification(new \DateTime('now'));
            $actualite->setUserModification($this->get('security.token_storage')->getToken()->getUser());
        } else {
            $actualite = new Actualite();
            $actualite->setDateCreation(new \DateTime('now'));
            $actualite->setDateModification(new \DateTime('now'));
            $actualite->setUserCreation($this->get('security.token_storage')->getToken()->getUser());
            $actualite->setUserModification($this->get('security.token_storage')->getToken()->getUser());
        }

        $form = $this->createForm(ActualiteType::class, $actualite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('manager.admin_actualite')->save($actualite);
        }

        $actualites = $this->get('manager.admin_actualite')->getAll();
        $table = $this->renderView('AdminBundle:Actualite:table_actualite.html.twig',
            array('actualites' => $actualites));
        $messages = $this->renderView('::Message/message.html.twig');

        return new JsonResponse(array(
            'table' => $table,
            'messages' => $messages
        ));
    }

    public function deleteAction(Request $request)
    {
        $this->get('manager.admin_actualite')->delete($request->get('id'));

        $actualites = $this->get('manager.admin_actualite')->getAll();
        $table = $this->renderView('AdminBundle:Actualite:table_actualite.html.twig',
            array('actualites' => $actualites));
        $messages = $this->renderView('::Message/message.html.twig');

        return new JsonResponse(array(
            'table' => $table,
            'messages' => $messages
        ));
    }

    public function formAction(Request $request)
    {
        if ($request->get('id') != 0) {
            $actualite = $this->get('manager.admin_actualite')->get($request->get('id'));
        } else {
            $actualite = new Actualite();
            $actualite->setId(0);
        }

        $form = $this->createForm(ActualiteType::class, $actualite);

        return $this->render('AdminBundle:Actualite:form_actualite.html.twig',
            array('form' => $form->createView()));
    }
}
