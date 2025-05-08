<?php

namespace App\Query;

use App\Entity\Organization;
use App\Entity\Project;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class TimeEntryQuery
{
    private ?int $organizationId = null;
    private ?int $projectId = null;
    private ?int $userId = null;
    private ?\DateTime $startDate = null;
    private ?\DateTime $endDate = null;

    public function __construct()
    {
        $request = Request::createFromGlobals();

        $this->endDate = new \DateTime('last monday');
        $this->startDate = clone $this->endDate;
        $this->startDate->modify('-7 days');
        $this->endDate->modify('-1 second');

        $organizationId = filter_var($request->query->get('organization'), FILTER_VALIDATE_INT);
        if ($organizationId) {
            $this->organizationId = $organizationId;
        }

        $userId = filter_var($request->query->get('user'), FILTER_VALIDATE_INT);
        if ($userId) {
            $this->userId = $userId;
        }

        $projectId = filter_var($request->query->get('project'), FILTER_VALIDATE_INT);
        if ($projectId) {
            $this->projectId = $projectId;
        }
    }

    public function setOrganization(Organization $organization)
    {
        $this->organizationId = $organization->getId();
    }

    public function getOrganizationId(): ?int
    {
        return $this->organizationId;
    }

    public function getProjectId(): ?int
    {
        return $this->projectId;
    }

    public function setProject(Project $project): void
    {
        $this->projectId = $project->getId();
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUser(User $user): void
    {
        $this->userId = $user->getId();
    }

    public function getStartDate(): ?\DateTime
    {
        return $this->startDate;
    }

    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }
}
