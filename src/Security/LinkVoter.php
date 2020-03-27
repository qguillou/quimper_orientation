<?php

// src/Security/NewsVoter.php
namespace App\Security;

use App\Entity\Link;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class LinkVoter extends ContentVoter
{
    protected function supports($attribute, $subject)
    {
        if (!$subject instanceof Link) {
            return false;
        }

        return parent::supports($attribute, $subject);
    }
}
