<?php

namespace App\Controller;

use App\Charts\OrganizationsPastWeek;
use App\Charts\ProjectsPastWeek;
use App\Form\FilterFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DashboardController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(OrganizationsPastWeek $organizationsPastWeek, ProjectsPastWeek $projectsPastWeek, Request $request): Response
    {
        $filterForm = $this->createForm(FilterFormType::class);
        $filterForm->handleRequest($request);

        return $this->render('dashboard/index.html.twig', [
            'organizations' => $organizationsPastWeek->getChart(),
            'projects' => $projectsPastWeek->getChart(),
            'filterForm' => $filterForm->createView(),
        ]);
    }
}
