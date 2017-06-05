<?php

namespace Bundle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Entity\Type;
use Bundle\AdminBundle\Form\TypeCourse\TypeCourseType;

class AdminTypeCourseController extends Controller
{
    public function indexAction()
    {
        $types = $this->get('manager.admin_type_course')->getAll();

        return $this->render('AdminBundle:TypeCourse:type.html.twig',
            array('types' => $types));
    }

    public function addAction(Request $request)
    {
        if ($request->request->get('type')['id'] != "0") {
            $type = $this->get('manager.admin_type_course')->get($request->request->get('type_course')['id']);
            $type->setDateModification(new \DateTime('now'));
            $type->setUserModification($this->get('security.token_storage')->getToken()->getUser());
        } else {
            $type = new Type();
            $type->setDateCreation(new \DateTime('now'));
            $type->setDateModification(new \DateTime('now'));
            $type->setUserCreation($this->get('security.token_storage')->getToken()->getUser());
            $type->setUserModification($this->get('security.token_storage')->getToken()->getUser());
        }

        $form = $this->createForm(TypeCourseType::class, $type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('manager.admin_type_course')->save($type);
        }

        $types = $this->get('manager.admin_type_course')->getAll();
        $table = $this->renderView('AdminBundle:TypeCourse:table_type.html.twig',
            array('types' => $types));
        $messages = $this->renderView('::Message/message.html.twig');

        return new JsonResponse(array(
            'table' => $table,
            'messages' => $messages
        ));
    }

    public function deleteAction(Request $request)
    {
        $this->get('manager.admin_type_course')->delete($request->get('id'));

        $types = $this->get('manager.admin_type_course')->getAll();
        $table = $this->renderView('AdminBundle:TypeCourse:table_type.html.twig',
            array('types' => $types));
        $messages = $this->renderView('::Message/message.html.twig');

        return new JsonResponse(array(
            'table' => $table,
            'messages' => $messages
        ));
    }

    public function formAction(Request $request)
    {
        if ($request->get('id') != 0) {
            $type = $this->get('manager.admin_type_course')->get($request->get('id'));
        } else {
            $type = new Type();
            $type->setId(0);
        }

        $form = $this->createForm(TypeCourseType::class, $type);

        return $this->render('AdminBundle:TypeCourse:form_type.html.twig',
            array('form' => $form->createView()));
    }
}
