<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CalendarController extends AbstractController
{
    #[Route('/calendar', name: 'app_calendar')]
    public function index(Request $request): Response
    {
        return $this->render('calendar/index.html.twig', [
            'api_endpoint' => $this->generateUrl('app_api_calendar', $request->query->all()),
        ]);
    }
}
