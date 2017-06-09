<?php

namespace Manager;

use Manager\DefaultManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;
use Form\Type\TarifType;
use Entity\Tarif;

class TarifManager extends DefaultManager
{
    public function create()
    {
        $tarif = new Tarif();

        return $tarif;
    }

    public function getFormClass()
    {
        return TarifType::class;
    }

    public function getAdminPageTitle()
    {
        return "Administration des tarifs";
    }

    public function getDisplayColumnTitle()
    {
        return array(
            'Libellé',
            'Prix'
        );
    }

    public function getDisplayColumn()
    {
        return array(
            'nom',
            'prix'
        );
    }

    public function getDisplayFormField()
    {
        return array(
            'nom',
            'prix'
        );
    }

    public function getOrderBy()
    {
        return array('prix' => 'ASC');
    }
}
