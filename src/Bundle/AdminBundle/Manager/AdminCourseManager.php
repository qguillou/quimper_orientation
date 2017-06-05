<?php

namespace Bundle\AdminBundle\Manager;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;
use Entity\Course;

class AdminCourseManager
{
    protected $em;
    protected $session;

    public function __construct(EntityManager $em, Session $session)
    {
        $this->em = $em;
        $this->session = $session;
    }

    public function get($id)
    {
        $repository = $this->em->getRepository('Entity\Course');
		$course = $repository->findOneById($id);

        return $course;
    }

    public function getAll()
    {
        $repository = $this->em->getRepository('Entity\Course');
		$courses = $repository->findBy(array(), array('date' => 'DESC'));

        return $courses;
    }

    public function save(Course $course)
    {
        $this->em->persist($course);
        $this->em->flush();

        $this->session->getFlashBag()->add(
          'success',
          'Édition réussie'
        );
    }

    public function delete($id)
    {
        $repository = $this->em->getRepository('Entity\Course');
		$course = $repository->findOneById($id);

        $this->em->remove($course);
        $this->em->flush();

        $this->session->getFlashBag()->add(
            'success',
            'Suppression réussie'
        );
    }
}
