<?php

namespace App\Service\Export;

use Symfony\Component\HttpFoundation\Request;
use App\Entity\Event;

interface ExportInterface
{
    function export(Event $event);
}
