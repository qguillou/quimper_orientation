<?php

// src/Security/EntityVoter.php
namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

abstract class ContentVoter extends Voter
{
    // these strings are just invented: you can use anything
    const VIEW = 'view';
    const EDIT = 'edit';
    const DELETE = 'delete';

    protected $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::VIEW, self::EDIT, self::DELETE])) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($subject, $user);
            case self::EDIT:
                return $this->canEdit($subject, $user);
            case self::DELETE:
                return $this->canDelete($subject, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canView($entity, $user)
    {
        if ($this->security->isGranted('ROLE_MEMBER')) {
            return true;
        }

        return !$entity->isPrivate();
    }

    private function canEdit($entity, $user)
    {
        if ($this->security->isGranted('ROLE_WEBMASTER')) {
            return true;
        }

        return false;
    }

    private function canDelete($map, $user)
    {
        if ($this->security->isGranted('ROLE_WEBMASTER')) {
            return true;
        }

        return false;
    }
}
