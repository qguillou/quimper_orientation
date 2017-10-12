<?php

namespace Manager;

use Manager\DefaultManager;
use Form\Type\TypeType;
use Entity\Type;

class TypeManager extends DefaultManager
{
    public function create()
    {
        $entity = new Type();

        return $entity;
    }

    public function getFormClass()
    {
        return TypeType::class;
    }

    public function getAdminPageTitle()
    {
        return "Administration des types de courses";
    }

    public function getDisplayColumnTitle()
    {
        return array(
            'Nom',
            'Couleur'
        );
    }

    public function getDisplayColumn()
    {
        return array(
            'nom',
            'color'
        );
    }

    public function getDisplayFormField()
    {
        return array(
            'nom',
            'color'
        );
    }

    public function getOrderBy()
    {
        return array('nom' => 'ASC');
    }
}
