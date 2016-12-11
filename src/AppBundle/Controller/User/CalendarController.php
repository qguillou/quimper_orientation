<?php

namespace AppBundle\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Course;
use AppBundle\Entity\Type;
use AppBundle\Entity\Inscrit;
use AppBundle\Form\Inscrit\InscritType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Form\Form;

class CalendarController extends Controller
{
	/**
	* @Route("/calendrier/")
	*/
	public function calendarAction()
	{
		$session = $this->get('app.session');
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('AppBundle:Course');
		$courses = $repository->findFutureCourse();
		return $this->render('user/calendar/calendar.html.twig', [
			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
			'user' => $this->getUser(),
			'isConnected' => $session->isAuthenticated(),
			'isAdmin' => $session->isAdmin(),
			'courses' => $courses,
		]);
	}

	/**
	*@Route("/calendrier/{id}/")
	*/
	public function courseAction($id, Request $request)
	{
		$session = $this->get('app.session');
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('AppBundle:Course');
		$course = $repository->findOneBy(array('id' => $id));
		$inscrits = array();

		$inscrit = new Inscrit();
		$inscrit->setCourse($course);
		if($session->isAuthenticated()){
			$inscrit->setUser($this->getUser());
			$inscrit->setNom($this->getUser()->getNom());
			$inscrit->setPrenom($this->getUser()->getPrenom());
			if($this->getUser()->getLicense()){
				$inscrit->setPuce($this->getUser()->getLicense()->getPuce());
				$inscrit->setLicence($this->getUser()->getLicense());
			}

			$em->persist($inscrit);
		}

		$form = $this->createForm(InscritType::class, $inscrit, array('course'=>$id));

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$this->saveInscrit($inscrit);
		}

		return $this->render('user/calendar/course.html.twig', [
			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
			'user' => $this->getUser(),
			'isConnected' => $session->isAuthenticated(),
			'isAdmin' => $session->isAdmin(),
			'course' => $course,
			'inscrits' => $inscrits,
			'form' => $form->createView(),
		]);
	}

	private function saveInscrit(Inscrit $inscrit)
	{
		try {
			$em = $this->getDoctrine()->getManager();
			$em->persist($inscrit);
			$em->flush();
			$this->get('session')->getFlashBag()->add(
				'success',
				'L\'inscription de '.$inscrit->getPrenom().' '.$inscrit->getNom().' a été enregistrée.'
			);
		}
		catch (UniqueConstraintViolationException $e){
			$this->get('session')->getFlashBag()->add(
				'error',
				'L\'inscription de '.$inscrit->getPrenom().' '.$inscrit->getNom().' n\'a pas pu être enregistrée, une erreur est survenue.'
			);
		}
		catch (\Exception $e){
			$this->get('session')->getFlashBag()->add(
				'error',
				'L\'inscription de '.$inscrit->getPrenom().' '.$inscrit->getNom().' n\'a pas pu être enregistrée, une erreur est survenue.'
			);
		}
	}
}
