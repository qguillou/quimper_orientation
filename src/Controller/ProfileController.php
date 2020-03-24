<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\UserFormType;
use App\Entity\Base;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="app_profile")
     */
    public function profile(): Response
    {
        if (!$this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app_register');
        }

        return $this->render('profile/show.html.twig');
    }

    /**
     * @Route("/profile/update", name="app_profile_update")
     */
    public function update(Request $request): Response
    {
        if (!$this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app_register');
        }

        $user = $this->getUser();
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!empty($form->get('baseId')->getData())) {
                $base = $this->getDoctrine()
                    ->getRepository(Base::class)
                    ->find($form->get('baseId')->getData());
                $user->setBase($base);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_profile');
        }

        return $this->render('profile/edit.html.twig', [
            'userForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/profile/delete", name="app_profile_delete")
     */
    public function delete(Request $request): Response
    {
        if ($this->isGranted('ROLE_USER')) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($this->getUser());
            $entityManager->flush();

            $this->get('security.token_storage')->setToken(null);
            $request->getSession()->invalidate();
        }

        return $this->redirectToRoute('app_homepage');
    }
}
