<?php

// src/Security/NewsVoter.php
namespace App\Security;

use App\Entity\Menu;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class MenuVoter extends ContentVoter
{
    protected function supports($attribute, $subject)
    {
        if (!$subject instanceof Menu) {
            return false;
        }

        return parent::supports($attribute, $subject);
    }
}
