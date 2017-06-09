<?php

namespace Manager;

use Manager\DefaultManager;
use Form\Type\CarteType;
use Entity\Carte;

class CarteManager extends DefaultManager
{
    public function create()
    {
        $entity = new Carte();

        return $entity;
    }

    public function getFormClass()
    {
        return CarteType::class;
    }

    public function getAdminPageTitle()
    {
        return "Administration des cartes";
    }

    public function getDisplayColumnTitle()
    {
        return array(
            'Affichée',
            'Nom',
            'Nombre de téléchargement'
        );
    }

    public function getDisplayColumn()
    {
        return array(
            'display',
            'nom',
            'nbTelechargement'
        );
    }

    public function getDisplayFormField()
    {
        return array(
            'display',
            'nom',
            'alert',
            'nbTelechargement'
        );
    }

    public function getOrderBy()
    {
        return array('nom' => 'ASC');
    }
}
