<?php

namespace App\Service\Entry;

use Symfony\Component\HttpFoundation\Request;
use App\Entity\Event;

interface EntryInterface
{
    function add(Event $event, ?array $datas): bool;
    function register(Event $event, ?array $datas): bool;
}
