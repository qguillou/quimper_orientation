<?php

namespace App\Service\Entry;

use Symfony\Component\HttpFoundation\Request;
use App\Entity\Event;
use App\Entity\User;

interface EntryInterface
{
    function register(Event $event, ?array $datas, ?User $user): bool;
}
