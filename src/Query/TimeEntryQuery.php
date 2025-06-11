<?php

namespace App\Query;

use Symfony\Component\HttpFoundation\Request;

class TimeEntryQuery
{
    private ?array $organizations = [];
    private ?array $projects = [];
    private ?array $users = [];
    private ?\DateTime $startDate = null;
    private ?\DateTime $endDate = null;

    public function __construct()
    {
        $request = Request::createFromGlobals();
        $this->endDate = new \DateTime('last monday');
        $this->startDate = clone $this->endDate;
        $this->startDate->modify('-7 days');
        $this->endDate->modify('-1 second');

        if ($request->query->has('start')) {
            try {
                $this->startDate = new \DateTime($request->query->get('start'));
            } catch (\Exception $e) {
            }
        }

        if ($request->query->has('end')) {
            try {
                $this->endDate = new \DateTime($request->query->get('end'));
            } catch (\Exception $e) {
            }
        }

        $organizations = $request->query->all('organization');
        if (!empty($organizations)) {
            foreach ($organizations as $organizationId) {
                $organizationId = filter_var($organizationId, FILTER_VALIDATE_INT);
                if ($organizationId) {
                    $this->addOrganization($organizationId);
                }
            }
        }

        $users = $request->query->all('user');
        if (!empty($users)) {
            foreach ($users as $userId) {
                $userId = filter_var($userId, FILTER_VALIDATE_INT);
                if ($userId) {
                    $this->addUser($userId);
                }
            }
        }

        $projects = $request->query->all('project');
        if (!empty($projects)) {
            foreach ($projects as $projectId) {
                $projectId = filter_var($projectId, FILTER_VALIDATE_INT);
                if ($projectId) {
                    $this->addProject($projectId);
                }
            }
        }
    }

    public function addOrganization(int $organizationId): void
    {
        $this->organizations[] = $organizationId;
    }

    public function getOrganizations(): array
    {
        return $this->organizations;
    }

    public function addProject(int $projectId): void
    {
        $this->projects[] = $projectId;
    }

    public function getProjects(): array
    {
        return $this->projects;
    }

    public function addUser(int $userId): void
    {
        $this->users[] = $userId;
    }

    public function getUsers(): array
    {
        return $this->users;
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
