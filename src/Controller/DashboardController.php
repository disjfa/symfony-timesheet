<?php

namespace App\Controller;

use App\Charts\OrganizationsPastWeek;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DashboardController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(OrganizationsPastWeek $projectsPastWeek): Response
    {
        return $this->render('dashboard/index.html.twig', [
            'chart' => $projectsPastWeek->getChart(),
        ]);
    }
}
