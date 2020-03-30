<?php

namespace App\Service\Entry;

use App\Annotation\Entry;
use App\Entity\Event;
use Doctrine\ORM\Query;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractEntry implements EntryInterface
{
    protected EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function add(Event $event, ?array $entries = array()): bool
    {
        if (empty($entries)) {
            return false;
        }

        return $this->register($event, $entries);
    }
}
