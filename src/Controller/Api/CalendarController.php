<?php

namespace App\Controller\Api;

use App\Event\GetCalendarEvents;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class CalendarController extends AbstractController
{
    /**
     * @throws \Exception
     */
    #[Route('/api/calendar', name: 'app_api_calendar')]
    public function index(Request $request, EventDispatcherInterface $eventDispatcher): JsonResponse
    {
        $start = new \DateTime($request->query->get('start', 'now'));
        $end = new \DateTime($request->query->get('end', 'now'));

        $calendarEvent = new GetCalendarEvents($start, $end, []);
        $eventDispatcher->dispatch($calendarEvent);

        return new JsonResponse($calendarEvent->getEvents());
    }
}
