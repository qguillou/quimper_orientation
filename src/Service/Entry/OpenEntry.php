<?php

namespace App\Service\Entry;

use App\Annotation\Entry;
use App\Entity\Base;
use App\Entity\User;
use App\Entity\Event;
use App\Entity\Circuit;
use App\Entity\People;
use Doctrine\ORM\Query;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class OpenEntry.
 *
 * @Entry(
 *     name="open"
 * )
 */
final class OpenEntry extends AbstractEntry
{
    public function register(Event $event, ?array $entries, ?User $user): bool
    {
        if (empty($entries)) {
            return false;
        }

        $circuitRepository = $this->em->getRepository(Circuit::class);

        foreach ($entries as $key => $entry)
        {
            $circuit = !empty($entry['circuit']) ? $circuitRepository->findOneById($entry['circuit']) : null;

            $people = new People();
            $people
                ->setBase($base)
                ->setEvent($event)
                ->setFirstName($base->getFirstName())
                ->setLastName($base->getLastName())
                ->setClub($base->getClub())
                ->setSi($entry['si'])
                ->setCircuit($circuit)
                ->setComment($entry['comment'])
            ;    
        }

        $this->em->flush();

        return true;
    }
}
