<?php

namespace App\Controller;

use App\Entity\Organization;
use App\Form\OrganizationType;
use App\Manager\TimeSheetManager;
use App\Query\TimeEntryQuery;
use App\Repository\OrganizationRepository;
use App\Repository\TimeEntryRepository;
use App\Security\Voter\OrganizationVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/organization')]
final class OrganizationController extends AbstractController
{
    #[Route(name: 'app_organization_index', methods: ['GET'])]
    public function index(OrganizationRepository $organizationRepository, TimeSheetManager $manager): Response
    {
        return $this->render('organization/index.html.twig', [
            'organizations' => $organizationRepository->findAll(),
            'manager' => $manager,
        ]);
    }

    #[Route('/new', name: 'app_organization_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        //        $this->denyAccessUnlessGranted(OrganizationVoter::CREATE, Organization::class);

        $organization = new Organization();
        $form = $this->createForm(OrganizationType::class, $organization);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($organization);
            $entityManager->flush();

            return $this->redirectToRoute('app_organization_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('organization/new.html.twig', [
            'organization' => $organization,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_organization_show', methods: ['GET'])]
    public function show(Organization $organization, TimeEntryRepository $timeEntryRepository, TimeEntryQuery $timeEntryQuery): Response
    {
        $timeEntryQuery->addOrganization($organization->getId());
        $manager = new TimeSheetManager($timeEntryRepository, $timeEntryQuery);

        return $this->render('organization/show.html.twig', [
            'organization' => $organization,
            'manager' => $manager,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_organization_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Organization $organization, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OrganizationType::class, $organization);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_organization_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('organization/edit.html.twig', [
            'organization' => $organization,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_organization_delete', methods: ['POST'])]
    public function delete(Request $request, Organization $organization, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$organization->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($organization);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_organization_index', [], Response::HTTP_SEE_OTHER);
    }
}
