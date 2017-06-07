<?php

namespace Manager;

use Manager\DefaultManager;
use Doctrine\ORM\EntityManager;
use Entity\Inscrit;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class InscritManager extends DefaultManager
{
    private $security;
    private $token;

    public function __construct(EntityManager $em, Session $session, TokenStorage $token, AuthorizationChecker $security)
    {
        $this->em = $em;
        $this->session = $session;
        $this->entity_namespace = 'Entity\Inscrit';
        $this->token = $token;
        $this->security = $security;
    }

    public function getInscrit($course)
    {
      $user = $this->token->getToken()->getUser();
      $inscrits = array();

      if($this->security->isGranted('ROLE_USER')) {
        //Adding current user
        $inscrit = new Inscrit();
        $inscrit->setCourse($course);
        $inscrit->setLicence($user->getLicense());
        $inscrit->setUser($user);
        $inscrit->setNom($user->getNom());
        $inscrit->setPrenom($user->getPrenom());
        $inscrit->setPuce($user->getLicense()->getPuce());
        $inscrits[] = $inscrit;

        //Adding attached user
        foreach($user->getUsers() as $userAttached) {
          $inscrit = new Inscrit();
          $inscrit->setCourse($course);
          $inscrit->setLicence($userAttached->getLicense());
          $inscrit->setUser($user);
          $inscrit->setNom($userAttached->getLicense()->getNom());
          $inscrit->setPrenom($userAttached->getLicense()->getPrenom());
          $inscrit->setPuce($userAttached->getLicense()->getPuce());
          $inscrits[] = $inscrit;
        }
      }

      return array("inscrits" => $inscrits);
    }

    public function unregister($id)
    {
      $inscrit = $this->em->getRepository('Entity\Inscrit')->find($id);

		  $course = $inscrit->getCourse();

      //Vérification que l'inscrit peut être supprimé par l'utilisateur courrant
      $user = $this->token->getToken()->getUser();
      if($user && ($inscrit->getUser() == $user)) {
        $this->em->remove($inscrit);
        $this->em->flush();
      }

      return $course;
    }

    public function register($id, $form)
    {
      $course = $this->em->getRepository('Entity\Course')->find($id);

      //Enregistrer les modifications
      foreach ($form->get('inscrits') as $inscrit) {
        //TODO - Ne fonctionne pas, pas d'inscription quand coché
        if($inscrit->get('add')->getData()) {
          $inscrit->getData()->setCourse($course);
          $this->em->persist($inscrit->getData());
        }
      }

      $this->em->flush();
      $this->session->getFlashBag()->add(
        'info',
        'Veuillez vérifier vos inscriptions ci-dessous, ou ouvrir de nouveau le formulaire d\'inscription pour obtenir des informations sur les erreurs.'
      );

      return $course;
    }
}
