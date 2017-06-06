<?php

namespace Bundle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Entity\Role;
use Bundle\AdminBundle\Form\Role\RoleType;

class AdminRoleController extends Controller
{
    public function indexAction()
    {
        $roles = $this->get('manager.role')->getAll();

        return $this->render('AdminBundle:Role:role.html.twig',
            array('roles' => $roles));
    }

    public function addAction(Request $request)
    {
        if ($request->request->get('role')['id'] != "0") {
            $role = $this->get('manager.role')->get($request->request->get('role')['id']);
            $role->setDateModification(new \DateTime('now'));
            $role->setUserModification($this->get('security.token_storage')->getToken()->getUser());
        } else {
            $role = new Role();
            $role->setDateCreation(new \DateTime('now'));
            $role->setDateModification(new \DateTime('now'));
            $role->setUserCreation($this->get('security.token_storage')->getToken()->getUser());
            $role->setUserModification($this->get('security.token_storage')->getToken()->getUser());
        }

        $form = $this->createForm(RoleType::class, $role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('manager.role')->save($role);
        }

        $roles = $this->get('manager.role')->getAll();
        $table = $this->renderView('AdminBundle:Role:table_role.html.twig',
            array('roles' => $roles));
        $messages = $this->renderView('::Message/message.html.twig');

        return new JsonResponse(array(
            'table' => $table,
            'messages' => $messages
        ));
    }

    public function deleteAction(Request $request)
    {
        $this->get('manager.role')->delete($request->get('id'));

        $roles = $this->get('manager.role')->getAll();
        $table = $this->renderView('AdminBundle:Role:table_role.html.twig',
            array('roles' => $roles));
        $messages = $this->renderView('::Message/message.html.twig');

        return new JsonResponse(array(
            'table' => $table,
            'messages' => $messages
        ));
    }

    public function formAction(Request $request)
    {
        if ($request->get('id') != 0) {
            $role = $this->get('manager.role')->get($request->get('id'));
        } else {
            $role = new Role();
            $role->setId(0);
            $role->setRole('ROLE_WEBMASTER');
        }

        $form = $this->createForm(RoleType::class, $role);

        return $this->render('AdminBundle:Role:form_role.html.twig',
            array('form' => $form->createView()));
    }
}
