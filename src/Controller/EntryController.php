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

class EntryController extends AbstractController
{
    private EntryManager $entryManager;

    public function __construct(EntryManager $entryManager)
    {
        $this->entryManager = $entryManager;
    }

    /**
     * @Route("/event/{id}/entry/{mode}/{club?2904}", name="app_event_entry")
     */
    public function entry(Request $request, Event $event, string $mode, ?Club $club, ClubRepository $clubRepository): Response
    {
        $status = $this->entryManager->create($mode)->add($event, $request->get('entry_form'));

        if ($status) {
            return $this->redirectToRoute('pi_crud_show', ['type' => 'event', 'id' => $event->getid()]);
        }

        return $this->render('entry/form_' . $mode . '.html.twig', [
            'event' => $event,
            'clubs' => $clubRepository->findAll(),
            'club' => $club
        ]);
    }
}
