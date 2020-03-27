<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\LinkFormType;
use App\Entity\Link;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use App\EventSubscriber\EntityMetadataSubscriber;
use App\Repository\LinkRepository;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LinkController extends AbstractController
{
    use TargetPathTrait;

    private $dispatcher;

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @Route("/admin/link/list", name="admin_link_list")
     */
    public function admin(LinkRepository $linkRepository)
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirect($this->getTargetPath($this->get('session'), 'main'));
        }

        return $this->render('link/admin.html.twig', [
            'fields' => ['label' => 'Libellé'],
            'entities' => $linkRepository->findAll()
        ]);
    }

    /**
     * @Route("/admin/link/{link}", name="admin_link_form", requirements={"link"="\d+"})
     */
    public function form(Request $request, ?Link $link = null)
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirect($this->getTargetPath($this->get('session'), 'main'));
        }

        $link = $link ?? new Link();
        $form = $this->createForm(LinkFormType::class, $link);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->dispatcher->dispatch(new GenericEvent($link), ($link->getId() ? 'app.entity.pre_update' : 'app.entity.pre_persist'));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($link);
            $entityManager->flush();
        }

        return $this->render('link/form.html.twig', [
            'link' => $link,
            'linkForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/link/{link}/delete", name="admin_link_delete", requirements={"link"="\d+"})
     */
    public function delete(Link $link)
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirect($this->getTargetPath($this->get('session'), 'main'));
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($link);
        $entityManager->flush();

        return $this->redirect($this->getTargetPath($this->get('session'), 'main'));
    }
}
