<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\NewsRepository;
use App\Repository\ClubRepository;
use App\Entity\Event;
use App\Entity\Club;
use App\Service\Entry\EntryManager;
use App\Service\Export\ExportManager;

class EntryController extends AbstractController
{
    private EntryManager $entryManager;
    private ExportManager $exportManager;

    public function __construct(EntryManager $entryManager, ExportManager $exportManager)
    {
        $this->entryManager = $entryManager;
        $this->exportManager = $exportManager;
    }

    /**
     * @Route("/event/{id}/entry/{mode}/{club?2904}", name="app_event_entry")
     */
    public function entry(Request $request, Event $event, string $mode, ?Club $club, ClubRepository $clubRepository): Response
    {
        $status = $this->entryManager->create($mode)->register($event, $request->get('entry_form'), $this->getUser());

        if ($status) {
            return $this->redirectToRoute('pi_crud_show', ['type' => 'event', 'id' => $event->getid()]);
        }

        return $this->render('entry/form_' . $mode . '.html.twig', [
            'event' => $event,
            'clubs' => $clubRepository->findAll(),
            'club' => $club
        ]);
    }

    /**
     * @Route("/event/{id}/export/{mode}", name="app_event_export")
     */
    public function export(Event $event, string $mode): Response
    {
        return $this->exportManager->create($mode)->export($event);
    }
}
