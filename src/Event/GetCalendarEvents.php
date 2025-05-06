<?php

namespace App\Event;

use App\Calendar\CalendarEvent;

class GetCalendarEvents
{
    /**
     * @var CalendarEvent[]
     */
    private array $events;

    public function __construct(
        private readonly \DateTime $start,
        private readonly \DateTime $end,
        private readonly array $filters,
    ) {
        $this->events = [];
    }

    public function getStart(): \DateTime
    {
        return $this->start;
    }

    public function getEnd(): \DateTime
    {
        return $this->end;
    }

    public function getFilters(): array
    {
        return $this->filters;
    }

    public function addEvent(CalendarEvent $event): self
    {
        $this->events[] = $event;

        return $this;
    }

    /**
     * @return CalendarEvent[]
     */
    public function getEvents(): array
    {
        return $this->events;
    }
}
