<?php

namespace Bundle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class AdminEntityController extends Controller
{
    public function indexAction($entity_type)
    {
        $manager = $this->get('manager.' . $entity_type);

        $entities = $manager->getAll($manager->getOrderBy());

        return $this->render('AdminBundle::admin_entity.html.twig',
            array(
                'page_title' => $manager->getAdminPageTitle(),
                'entity_type' => $entity_type,
                'columns_title' => $manager->getDisplayColumnTitle(),
                'columns' => $manager->getDisplayColumn(),
                'entities' => $entities,
                'editable' => $manager->isEditable()
            )
        );
    }

    public function formAction($entity_type, $id)
    {
        $manager = $this->get('manager.' . $entity_type);
        $entity = $manager->get($id);
        $form = $this->createForm($manager->getFormClass(), $entity, array());

        return $this->render('AdminBundle::form_admin_entity.html.twig',
            array(
                'form' => $form->createView(),
                'display_form_fields' => $manager->getDisplayFormField(),
                'entity_type' => $entity_type,
            )
        );
    }

    public function saveAction(Request $request, $entity_type)
    {
        $manager = $this->get('manager.' . $entity_type);
        $entity = $manager->get($request->request->get($entity_type)['id']);
        $form = $this->createForm($manager->getFormClass(), $entity, array());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->save($entity);
        }

        $entities = $manager->getAll($manager->getOrderBy());
        $table = $this->renderView('AdminBundle::table_admin_entity.html.twig',
            array(
                'columns' => $manager->getDisplayColumn(),
                'entities' => $entities,
                'editable' => $manager->isEditable()
            )
        );
        $messages = $this->renderView('::Message/message.html.twig');

        return new JsonResponse(array(
            'table' => $table,
            'messages' => $messages
        ));
    }

    public function deleteAction($entity_type, $id)
    {
        $manager = $this->get('manager.' . $entity_type);
        $manager->delete($id);

        $entities = $manager->getAll($manager->getOrderBy());
        $table = $this->renderView('AdminBundle::table_admin_entity.html.twig',
            array(
                'columns' => $manager->getDisplayColumn(),
                'entities' => $entities,
                'editable' => $manager->isEditable()
            )
        );
        $messages = $this->renderView('::Message/message.html.twig');

        return new JsonResponse(array(
            'table' => $table,
            'messages' => $messages
        ));
    }
}
