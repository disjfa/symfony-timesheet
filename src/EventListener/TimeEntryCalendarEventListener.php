<?php

namespace App\EventListener;

use App\Calendar\CalendarEvent;
use App\Entity\TimeEntry;
use App\Event\GetCalendarEvents;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener]
class TimeEntryCalendarEventListener
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(GetCalendarEvents $getCalendarEvents): void
    {
        $timeEntryRepository = $this->entityManager->getRepository(TimeEntry::class);
        $timeEntryQuery = $timeEntryRepository->createQueryBuilder('te')
            ->where('te.start_date >= :start')
            ->andWhere('te.start_date <= :end')
            ->setParameter('start', $getCalendarEvents->getStart())
            ->setParameter('end', $getCalendarEvents->getEnd())
            ->orderBy('te.start_date', 'ASC');

        $timeEntries = $timeEntryQuery->getQuery()->getResult();
        foreach ($timeEntries as $timeEntry) {
            /* @var TimeEntry $timeEntry */

            $getCalendarEvents->addEvent(
                new CalendarEvent(
                    id: $timeEntry->getId(),
                    title: $timeEntry->getProject()->getName(),
                    start: $timeEntry->getStartDate(),
                    end: $timeEntry->getEndDate()
                )
            );
        }
    }
}
