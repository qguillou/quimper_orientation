<?php

namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\User;
use AppBundle\Entity\Course;
use AppBundle\Form\Course\CourseType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\Form\Form;

class CalendarAdminController extends Controller
{
	   /**
     * @Route("/admin/calendrier/")
     */
    public function calendar(Request $request)
    {
        $course = new Course();
        return $this->renderCalendarAdminPage($request, $course);
    }

    /**
  	* @Route("/admin/calendrier/{id}/")
  	*/
  	public function adminParcoursById($id, Request $request)
  	{
  		$em = $this->getDoctrine()->getManager();
  		$repository = $em->getRepository('AppBundle:Course');
  		$course = $repository->findOneBy(array('id' => $id));

  		return $this->renderCalendarAdminPage($request, $course);
  	}


    /**
  	* Function to render the page
  	* @param Request $request
  	* @param Course $course
  	*/
  	private function renderCalendarAdminPage(Request $request, Course $course)
  	{
      $session = $this->get('app.session');
      $em = $this->getDoctrine()->getManager();
      $repository = $em->getRepository('AppBundle:Course');
      $courses = $repository->findFutureCourse();

      $form = $this->createForm(CourseType::class, $course);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
				if($form->get('save')->isClicked())
				return $this->save($course, $form);
				else
				return $this->delete($course);
      }

      return $this->render('admin/calendar/calendar.html.twig', [
          'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
          'user' => $this->getUser(),
          'isConnected' => $session->isAuthenticated(),
          'isAdmin' => $session->isAdmin(),
          'courses' => $courses,
          'active' => $course->getId(),
          'form' => $form->createView(),
      ]);
    }

		/**
		* Function to save a course
		* @param Course $course the course entity to save into database
		* @return the redirect view
		*/
		private function save(Course $course, Form $form)
		{
			try {
				$em = $this->getDoctrine()->getManager();
				$em->persist($course);
				$em->flush();

				if($form->get('annonce')->getData()){
					$form->get('annonce')->getData()->move($this->getParameter('courses').'/'.$course->getId(), 'annonce.pdf');
				}
				if($form->get('files')->getData()){
					foreach($form->get('files')->getData() as $file){
						$file->move($this->getParameter('courses').'/'.$course->getId().'/autres', $file->getClientOriginalName());
					}
				}
			}
			catch (UniqueConstraintViolationException $e){
				$this->get('session')->getFlashBag()->add(
					'error',
					'La course '.$course->getNom().' n\'a pas pu être modifiée, une erreur est survenue.'
				);

				$em = $this->getDoctrine()->getManager();
				$repository = $em->getRepository('AppBundle:Course');
				$courses = $repository->findFutureCourse();

				return $this->render(
					'admin/parcours/parcours.html.twig',
					array('form' => $form->createView(),
					'user' => $this->getUser(),
					'isConnected' => $session->isAuthenticated(),
					'isAdmin' => $session->isAdmin(),
					'active' => $course->getId(),
					'course' => $coursess)
				);
			}

			$this->get('session')->getFlashBag()->add(
				'success',
				'La course '.$course->getNom().' a été modifiée.'
			);
			return $this->redirect('/admin/calendrier/'.$course->getId());
		}

		/**
		* Function to delete a course
		* @param Course $course the course entity to delete into database
		* @return the redirect view
		*/
		private function delete(Course $course)
		{
			$em = $this->getDoctrine()->getManager();
			$id = $course->getId();
			$em->remove($course);
			$em->flush();

			$this->deleteFile($id);

			$this->get('session')->getFlashBag()->add(
				'success',
				'La course '.$course->getNom().' a été supprimée.'
			);

			return $this->redirect('/admin/calendrier/');
		}

		/**
		* Function to delete file and folder associate to a course
		*/
		private function deleteFile($id)
		{
				$src = "web/files/courses/".$id;
				$dir = opendir($src);
		    while(false !== ( $file = readdir($dir)) ) {
		        if (( $file != '.' ) && ( $file != '..' )) {
		            $full = $src . '/' . $file;
		            if ( is_dir($full) ) {
		                rrmdir($full);
		            }
		            else {
		                unlink($full);
		            }
		        }
		    }
		    closedir($dir);
		    rmdir($src);
		}
}
