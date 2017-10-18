<?php

namespace Manager;

use Manager\DefaultManager;
use Form\Type\CourseType;
use Entity\Course;
use Entity\User;

class CourseManager extends DefaultManager
{
    public function getCalendar()
    {
        $repository = $this->em->getRepository($this->entity_namespace);
		$entities = $repository->findFutureCourse();

        return $entities;
    }

    public function getUserCalendar(User $user)
    {
        $repository = $this->em->getRepository($this->entity_namespace);
		$entities = $repository->findCourseWhereUserIsRegistered($user);

        return $entities;
    }

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

    public function getPrev(Course $course)
    {
        $repository = $this->em->getRepository($this->entity_namespace);
		$entity = $repository->findPrev($course);

        return $entity;
    }

    public function getNext(Course $course)
    {
        $repository = $this->em->getRepository($this->entity_namespace);
		$entity = $repository->findNext($course);

        return $entity;
    }
}
