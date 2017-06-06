<?php

namespace Bundle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

abstract class DefaultAdminController extends Controller
{
    public abstract function getFormClass();
    public abstract function getManager();
    public abstract function getEntityType();
    public abstract function getEntityName();
    public abstract function getTable();
    public abstract function getForm($form);

    public function addAction(Request $request)
    {
        if ($request->request->get($this->getEntityName())['id'] != "0") {
            $entity = $this->getManager()->get($request->request->get($this->getEntityName())['id']);
            $entity->setDateModification(new \DateTime('now'));
            $entity->setUserModification($this->get('security.token_storage')->getToken()->getUser());
        } else {
            $entity = $this->getEntityType();
            $entity->setDateCreation(new \DateTime('now'));
            $entity->setDateModification(new \DateTime('now'));
            $entity->setUserCreation($this->get('security.token_storage')->getToken()->getUser());
            $entity->setUserModification($this->get('security.token_storage')->getToken()->getUser());
        }

        $form = $this->createForm($this->getFormClass(), $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getManager()->save($entity);
        }

        $table = $this->getTable();
        $messages = $this->renderView('::Message/message.html.twig');

        return new JsonResponse(array(
            'table' => $table,
            'messages' => $messages
        ));
    }

    public function deleteAction(Request $request)
    {
        $this->getManager()->delete($request->get('id'));

        $table = $this->getTable();
        $messages = $this->renderView('::Message/message.html.twig');

        return new JsonResponse(array(
            'table' => $table,
            'messages' => $messages
        ));
    }

    public function formAction(Request $request)
    {
        if ($request->get('id') != 0) {
            $entity = $this->getManager()->get($request->get('id'));
        } else {
            $entity = $this->getEntityType();
            $entity->setId(0);
        }

        $form = $this->createForm($this->getFormClass(), $entity);

        return $this->getForm($form);
    }
}
