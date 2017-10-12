<?php

namespace Manager;

use Manager\DefaultManager;
use Form\Type\RoleType;
use Entity\Role;

class RoleManager extends DefaultManager
{
    public function create()
    {
        $entity = new Role();

        return $entity;
    }

    public function getFormClass()
    {
        return RoleType::class;
    }

    public function getAdminPageTitle()
    {
        return "Administration des rôles";
    }

    public function getDisplayColumnTitle()
    {
        return array(
            'Utilisateur',
            'Rôle'
        );
    }

    public function getDisplayColumn()
    {
        return array(
            'user',
            'role'
        );
    }

    public function getDisplayFormField()
    {
        return array(
            'user',
            'role'
        );
    }

    public function getOrderBy()
    {
        return array();
    }
}
