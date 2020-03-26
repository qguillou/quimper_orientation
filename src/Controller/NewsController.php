<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\NewsFormType;
use App\Entity\News;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use App\EventSubscriber\EntityMetadataSubscriber;
use App\Repository\NewsRepository;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class NewsController extends AbstractController
{
    use TargetPathTrait;

    private $dispatcher;

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @Route("/news", name="app_news_list")
     */
    public function index()
    {
        return $this->render('news/index.html.twig', [
            'controller_name' => 'NewsController',
        ]);
    }

    /**
     * @Route("/news/{news}", name="app_news_show")
     */
    public function show(News $news)
    {
        return $this->render('news/show.html.twig', [
            'news' => $news,
        ]);
    }

    /**
     * @Route("/admin/news/list", name="admin_news_list")
     */
    public function admin(NewsRepository $newsRepository)
    {
        return $this->render('news/admin.html.twig', [
            'fields' => ['title' => 'Titre'],
            'entities' => $newsRepository->findAll()
        ]);
    }

    /**
     * @Route("/admin/news/{news}", name="admin_news_form", requirements={"news"="\d+"})
     */
    public function form(Request $request, ?News $news = null)
    {
        $news = $news ?? new News();
        $form = $this->createForm(NewsFormType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->dispatcher->dispatch(new GenericEvent($news), ($news->getId() ? 'app.entity.pre_update' : 'app.entity.pre_persist'));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($news);
            $entityManager->flush();
        }

        return $this->render('news/form.html.twig', [
            'news' => $news,
            'newsForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/news/{news}/delete", name="admin_news_delete", requirements={"news"="\d+"})
     */
    public function delete(News $news)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($news);
        $entityManager->flush();

        return $this->redirect($this->getTargetPath($this->get('session'), 'main'));
    }
}
