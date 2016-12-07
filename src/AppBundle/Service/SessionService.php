<?php

namespace AppBundle\Service;

use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class SessionService
{
    protected $security;

    public function setSecurity(AuthorizationChecker $security){
        $this->security = $security;
    }

    public function isAdmin(){
      return $this->security->isGranted('ROLE_ADMIN');
    }

    public function isWebmaster(){
      return $this->security->isGranted('ROLE_WEBMASTER');
    }

    public function isAuthenticated(){
      return $this->security->isGranted('IS_AUTHENTICATED_REMEMBERED');
    }

    public function onlyUserAccess(){
      if(!($this->security->isGranted('ROLE_USER'))){
        
      }
    }
}
