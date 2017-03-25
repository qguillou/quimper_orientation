<?php

namespace Bundle\CalendarBundle\Manager;

use Doctrine\ORM\EntityManager;

class CourseManager
{
    protected $em;

    public function __construct(EntityManager $em)
    {
      $this->em = $em;
    }

    public function getCourse()
    {
      $repository = $this->em->getRepository('Entity\Course');

      return $repository->findFutureCourse();
    }

    public function getCourseById($id)
    {
      $repository = $this->em->getRepository('Entity\Course');

      return $repository->findOneBy(array('id' => $id));
    }
}
