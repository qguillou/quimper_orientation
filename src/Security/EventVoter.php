<?php

// src/Security/EventVoter.php
namespace App\Security;

use App\Entity\Event;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class EventVoter extends ContentVoter
{
    const REGISTER = 'register';
    
    protected function supports($attribute, $subject)
    {
        if (!$subject instanceof Event) {
            return false;
        }

        if (in_array($attribute, [self::REGISTER])) {
            return true;
        }

        return parent::supports($attribute, $subject);
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        switch ($attribute) {
            case self::REGISTER:
                return $this->canRegister($subject, $user);
            default:
                return parent::voteOnAttribute($attribute, $subject, $token);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canRegister($entity, $user)
    {
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

        if ($event->getAllowEntries() && $event->getDateEntries()->format('U') > date('U')) {
            return true;
        }

        return false;
    }
}
