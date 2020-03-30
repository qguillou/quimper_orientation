<?php

namespace App\Model;

use App\Entity\Event;

Trait EventReferenceTrait
{
    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(Event $event): self
    {
        $this->event = $event;

        return $this;
    }
}
