<?php

namespace Manager;

use Manager\DefaultManager;
use Form\Type\ContactType;
use Entity\Contact;

class ContactManager extends DefaultManager
{
    public function create()
    {
        $entity = new Contact();

        return $entity;
    }

    public function getFormClass()
    {
        return ContactType::class;
    }

    public function getAdminPageTitle()
    {
        return "Administration des contacts";
    }

    public function getDisplayColumnTitle()
    {
        return array(
            'Fonction',
            'Nom',
            'Prénom'
        );
    }

    public function getDisplayColumn()
    {
        return array(
            'fonction',
            'nom',
            'prenom'
        );
    }

    public function getDisplayFormField()
    {
        return array(
            'display',
            'fonction',
            'nom',
            'prenom',
            'adresse',
            'mail',
            'telephone',
            'portable',
        );
    }



    public function getOrderBy()
    {
        return array('fonction' => 'ASC');
    }
}
