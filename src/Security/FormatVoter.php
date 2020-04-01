<?php

// src/Security/NewsVoter.php
namespace App\Security;

use App\Entity\Format;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class FormatVoter extends ContentVoter
{
    protected function supports($attribute, $subject)
    {
        if (!$subject instanceof Format) {
            return false;
        }

        return parent::supports($attribute, $subject);
    }
}
