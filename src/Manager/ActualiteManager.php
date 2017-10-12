<?php

namespace Manager;

use Manager\DefaultManager;
use Form\Type\ActualiteType;
use Entity\Actualite;

class ActualiteManager extends DefaultManager
{
    public function create()
    {
        $entity = new Actualite();

        return $entity;
    }

    public function getFormClass()
    {
        return ActualiteType::class;
    }

    public function getAdminPageTitle()
    {
        return "Administration des actualités";
    }

    public function getDisplayColumnTitle()
    {
        return array(
            'Titre',
            'Date de publication'
        );
    }

    public function getDisplayColumn()
    {
        return array(
            'titre',
            'dateCreation'
        );
    }

    public function getDisplayFormField()
    {
        return array(
            'titre',
            'contenu'
        );
    }

    public function getOrderBy()
    {
        return array('dateCreation' => 'DESC');
    }
}
