<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\MenuFormType;
use App\Entity\Menu;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use App\EventSubscriber\EntityMetadataSubscriber;
use App\Repository\MenuRepository;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class MenuController extends AbstractController
{
    use TargetPathTrait;

    private $dispatcher;

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @Route("/admin/menu/list", name="admin_menu_list")
     */
    public function admin(MenuRepository $menuRepository)
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            //return $this->redirect($this->getTargetPath($this->get('session'), 'main'));
        }

        return $this->render('menu/admin.html.twig', [
            'fields' => ['label' => 'Libellé'],
            'entities' => $menuRepository->findAll()
        ]);
    }

    /**
     * @Route("/admin/menu/{menu}", name="admin_menu_form", requirements={"menu"="\d+"})
     */
    public function form(Request $request, ?Menu $menu = null)
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            //return $this->redirect($this->getTargetPath($this->get('session'), 'main'));
        }

        $menu = $menu ?? new Menu();
        $form = $this->createForm(MenuFormType::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->dispatcher->dispatch(new GenericEvent($menu), ($menu->getId() ? 'app.entity.pre_update' : 'app.entity.pre_persist'));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($menu);
            $entityManager->flush();
        }

        return $this->render('menu/form.html.twig', [
            'menu' => $menu,
            'menuForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/menu/{menu}/delete", name="admin_menu_delete", requirements={"menu"="\d+"})
     */
    public function delete(Menu $menu)
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirect($this->getTargetPath($this->get('session'), 'main'));
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($menu);
        $entityManager->flush();

        return $this->redirect($this->getTargetPath($this->get('session'), 'main'));
    }
}
