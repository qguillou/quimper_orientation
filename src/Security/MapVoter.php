<?php

// src/Security/MapVoter.php
namespace App\Security;

use App\Entity\Map;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class MapVoter extends ContentVoter
{
    protected function supports($attribute, $subject)
    {
        if (!$subject instanceof Map) {
            return false;
        }

        return parent::supports($attribute, $subject);
    }
}
