<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Form\UsernameFormType;
use App\Form\PasswordFormType;
use App\Entity\User;
use Symfony\Component\Form\FormError;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
             return $this->redirectToRoute('app_homepage');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/reset-password", name="app_request_reset")
     */
    public function requestPassword(Request $request)
    {
        if ($this->getUser()) {
             return $this->redirectToRoute('app_profile');
        }

        $form = $this->createForm(UsernameFormType::class, []);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getDoctrine()
                ->getRepository(User::class)
                ->findOneByEmail($form->get('email')->getData());

            if ($user) {
                $user->setToken(md5(random_bytes(20)));

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                $dispatcher = new EventDispatcher();
                $event = new GenericEvent($user);
                $dispatcher->dispatch($event, 'security.reset_password');

                return $this->redirectToRoute('app_login');
            }

            $form->addError(new FormError('Cette adresse e-mail n\'existe pas sur notre site.'));
        }

        return $this->render('security/reset_password.html.twig', [
            'usernameForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/reset-password/{token}", name="app_reset")
     */
    public function resetPassword(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneByToken($token);

        if (!$user) {
            return $this->redirectToRoute('app_homepage');
        }

        $form = $this->createForm(PasswordFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/change_password.html.twig', [
            'passwordForm' => $form->createView(),
        ]);
    }
}
