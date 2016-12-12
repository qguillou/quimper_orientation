<?php

namespace AppBundle\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Inscrit;
use AppBundle\Form\Type\InscritType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class CalendarController extends Controller
{
	private $session;

	/**
	* @Route("/calendrier/")
	*/
	public function calendarAction()
	{
		$this->session = $this->get('app.session');
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('AppBundle:Course');
		$courses = $repository->findFutureCourse();
		return $this->render('user/calendar/calendar.html.twig', [
			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
			'courses' => $courses,
		]);
	}

	/**
	*@Route("/calendrier/{id}/")
	*/
	public function courseAction($id, Request $request)
	{
		$this->session = $this->get('app.session');
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('AppBundle:Course');

		$inscrit = new Inscrit();
		$inscrit->setCourse($repository->findOneBy(array('id' => $id)));
		if($this->session->isAuthenticated()){
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
			'course' => $inscrit->getCourse(),
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
