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
 * Class QuickEntry.
 *
 * @Entry(
 *     name="quick"
 * )
 */
final class QuickEntry extends AbstractEntry
{
    public function register(Event $event, ?array $entry, ?User $user): bool
    {
        if (count($event->getCircuits()) > 0 && empty($entry)) {
            return false;
        }

        if (empty($user)) {
            return false;
        }

        $circuitRepository = $this->em->getRepository(Circuit::class);
        $circuit = !empty($entry['circuit']) ? $circuitRepository->findOneById($entry['circuit']) : null;

        $people = new People();
        $people
            ->setBase($user->getBase())
            ->setEvent($event)
            ->setFirstName($user->getFirstName())
            ->setLastName($user->getLastName())
            ->setClub($user->getBase()->getClub())
            ->setSi($user->getBase()->getSi())
            ->setCircuit($circuit)
            ->setComment($entry['comment'])
        ;

        $this->em->persist($people);
        $this->em->flush();

        return true;
    }
}
