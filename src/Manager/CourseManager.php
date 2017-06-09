<?php

namespace Manager;

use Manager\DefaultManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;
use Form\Type\CourseType;
use Entity\Course;

class CourseManager extends DefaultManager
{
    public function create()
    {
        $entity = new Course();

        return $entity;
    }

    public function getFormClass()
    {
        return CourseType::class;
    }

    public function getAdminPageTitle()
    {
        return "Administration des courses";
    }

    public function getDisplayColumnTitle()
    {
        return array(
            'Date',
            'Nom'
        );
    }

    public function getDisplayColumn()
    {
        return array(
            'date',
            'nom'
        );
    }

    public function getDisplayFormField()
    {
        return array(
            'nom',
            'date',
            'lieu',
            'gps',
            'organisateur',
            'type',
            'inscription',
            'modification',
            'site'
        );
    }



    public function getOrderBy()
    {
        return array('date' => 'DESC');
    }
}
