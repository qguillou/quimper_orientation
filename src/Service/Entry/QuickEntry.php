<?php

namespace App\Service\Entry;

use App\Annotation\Entry;
use App\Entity\Event;
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
    public function register(Event $event, ?array $entries): bool
    {
        
    }
}
