<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\MapFormType;
use App\Entity\Map;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use App\EventSubscriber\EntityMetadataSubscriber;
use App\Repository\MapRepository;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class MapController extends AbstractController
{
    use TargetPathTrait;

    private $dispatcher;

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @Route("/map", name="app_map_list")
     */
    public function list(MapRepository $mapRepository)
    {
        return $this->render('map/list.html.twig', [
            'entities' => $mapRepository->findAll()
        ]);
    }

    /**
     * @Route("/admin/map/list", name="admin_map_list")
     */
    public function admin(MapRepository $mapRepository)
    {
        return $this->render('map/admin.html.twig', [
            'fields' => ['title' => 'Titre'],
            'entities' => $mapRepository->findAll()
        ]);
    }

    /**
     * @Route("/admin/map/{map}", name="admin_map_form", requirements={"map"="\d+"})
     */
    public function form(Request $request, ?Map $map = null)
    {
        $map = $map ?? new Map();
        $form = $this->createForm(MapFormType::class, $map);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->dispatcher->dispatch(new GenericEvent($map), ($map->getId() ? 'app.entity.pre_update' : 'app.entity.pre_persist'));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($map);
            $entityManager->flush();
        }

        return $this->render('map/form.html.twig', [
            'map' => $map,
            'mapForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/map/{map}/delete", name="admin_map_delete", requirements={"map"="\d+"})
     */
    public function delete(Map $map)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($map);
        $entityManager->flush();

        return $this->redirect($this->getTargetPath($this->get('session'), 'main'));
    }
}
