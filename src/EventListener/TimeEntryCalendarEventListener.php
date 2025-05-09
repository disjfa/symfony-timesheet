<?php

namespace App\EventListener;

use App\Calendar\CalendarEvent;
use App\Entity\TimeEntry;
use App\Event\GetCalendarEvents;
use App\Query\TimeEntryQuery;
use App\Repository\TimeEntryRepository;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener]
class TimeEntryCalendarEventListener
{
    private TimeEntryRepository $timeEntryRepository;
    private TimeEntryQuery $timeEntryQuery;

    public function __construct(TimeEntryRepository $timeEntryRepository, TimeEntryQuery $timeEntryQuery)
    {
        $this->timeEntryRepository = $timeEntryRepository;
        $this->timeEntryQuery = $timeEntryQuery;
    }

    public function __invoke(GetCalendarEvents $getCalendarEvents): void
    {
        $timeEntries = $this->timeEntryRepository->findWithQuery($this->timeEntryQuery);

        foreach ($timeEntries as $timeEntry) {
            /* @var TimeEntry $timeEntry */

            $getCalendarEvents->addEvent(
                new CalendarEvent(
                    id: $timeEntry->getId(),
                    title: $timeEntry->getProject()->getName(),
                    start: $timeEntry->getStartDate(),
                    end: $timeEntry->getEndDate(),
                    backgroundColor: $timeEntry->getProject()->getColor(),
                )
            );
        }
    }
}
