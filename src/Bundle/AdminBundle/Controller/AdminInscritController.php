<?php

namespace Bundle\AdminBundle\Controller;

use Bundle\AdminBundle\Controller\DefaultAdminController;
use Entity\Inscrit;
use Form\Type\InscritType;
use Symfony\Component\HttpFoundation\Request;

class AdminInscritController extends DefaultAdminController
{
    public function indexAction()
    {
        $entities = $this->getManager()->getAll();

        return $this->render('AdminBundle:Inscrit:inscrit.html.twig', array('entities' => $entities));
    }

    protected function getFormClass()
    {
        return InscritType::class;
    }

    protected function getManager()
    {
        return $this->get('manager.inscrit');
    }

    protected function getEntityType()
    {
        return new Inscrit();
    }

    protected function getEntityName()
    {
        return 'inscrit';
    }

    protected function getTable()
    {
        $entities = $this->getManager()->getAll();

        return $this->renderView('AdminBundle:Inscrit:table_inscrit.html.twig', array('entities' => $entities));
    }

    protected function getForm($form)
    {
        return $this->render('AdminBundle:Inscrit:form_inscrit.html.twig',
            array('form' => $form->createView()));
    }

    public function formAction(Request $request)
    {
        if ($request->get('id') != 0) {
            $entity = $this->getManager()->get($request->get('id'));
        } else {
            $entity = $this->getEntityType();
            $entity->setId(0);
        }

        $form = $this->createForm($this->getFormClass(), $entity, array('course' => $entity->getCourse()));

        return $this->getForm($form);
    }
}
