<?php

namespace Bundle\CalendarBundle\Manager;

use Doctrine\ORM\EntityManager;
use Entity\Inscrit;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class InscritManager
{
    protected $em;
    private $security;
    private $token;
    private $session;

    public function __construct(EntityManager $em, TokenStorage $token, AuthorizationChecker $security, $session)
    {
      $this->em = $em;
      $this->token = $token;
      $this->security = $security;
      $this->session = $session;
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

    public function saveInscrit(Request $request, Array $data)
    {
      $inscrits = $request->get('collection_inscrit')['inscrits'];
      $size = sizeof($inscrits);
      for ($i = 0; $i < $size; $i++) {
        if(isset($inscrits[$i]['add'])) {
          $this->em->persist($data[$i]);
        }
      }

      $this->em->flush();
      $this->session->getFlashBag()->add(
        'info',
        'Veuillez vérifier vos inscriptions ci-dessous, ou ouvrir de nouveau le formulaire d\'inscription pour obtenir des informations sur les erreurs.'
      );
    }

    public function unregister($id)
    {
      $inscrit = $this->em->getRepository('Entity\Inscrit')->find($id);
		  $course = $inscrit->getCourse();
			$this->em->remove($inscrit);
			$this->em->flush();
      
      return $course;
    }
}
