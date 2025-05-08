<?php

namespace App\Manager;

use App\Entity\Organization;
use App\Entity\Project;
use App\Entity\Task;
use App\Query\TimeEntryQuery;
use App\Repository\TimeEntryRepository;

class TimeSheetManager
{
    private TimeEntryRepository $timEntryRepository;

    private $organizations = [];
    private $projects = [];
    private $users = [];
    private $tasks = [];
    private $subtasks = [];
    private TimeEntryQuery $timeEntryQuery;

    public function __construct(TimeEntryRepository $timEntryRepository, TimeEntryQuery $timeEntryQuery)
    {
        $this->timEntryRepository = $timEntryRepository;
        $this->timeEntryQuery = $timeEntryQuery;
        $this->init();
    }

    public function init()
    {
        $timeEntries = $this->timEntryRepository->findWithQuery($this->timeEntryQuery);

        foreach ($timeEntries as $timeEntry) {
            $project = $timeEntry->getProject();
            $organization = $project->getOrganization();
            $user = $timeEntry->getUser();
            $task = $timeEntry->getTask();
            $subtask = $timeEntry->getSubtask();

            if (!isset($this->organizations[$organization->getId()])) {
                $this->organizations[$organization->getId()] = [
                    'id' => $organization->getId(),
                    'name' => $organization->getName(),
                    'color' => $organization->getColor(),
                    'seconds' => 0,
                ];
            }
            $this->organizations[$organization->getId()]['seconds'] += $timeEntry->getSeconds();

            if (!isset($this->projects[$project->getId()])) {
                $this->projects[$project->getId()] = [
                    'id' => $project->getId(),
                    'name' => $project->getName(),
                    'color' => $project->getColor(),
                    'seconds' => 0,
                ];
            }
            $this->projects[$project->getId()]['seconds'] += $timeEntry->getSeconds();

            if (!isset($this->users[$user->getId()])) {
                $this->users[$user->getId()] = [
                    'id' => $user->getId(),
                    'name' => $user->getEmail(),
                    'seconds' => 0,
                ];
            }
            $this->users[$user->getId()]['seconds'] += $timeEntry->getSeconds();

            $taskId = $task ? $task->getId() : 0;
            if (!isset($this->tasks[$taskId])) {
                $this->tasks[$taskId] = [
                    'id' => $taskId,
                    'name' => $task ? $task->getId() : 'Unknown',
                    'seconds' => 0,
                ];
            }
            $this->tasks[$taskId]['seconds'] += $timeEntry->getSeconds();
        }

        usort($this->organizations, static function ($a, $b) {
            return $a['seconds'] < $b['seconds'];
        });
        usort($this->projects, static function ($a, $b) {
            return $a['seconds'] < $b['seconds'];
        });
        usort($this->users, static function ($a, $b) {
            return $a['seconds'] < $b['seconds'];
            //            return strcmp($a['name'], $b['name']);
        });
    }

    public function getOrganizations(): array
    {
        return $this->organizations;
    }

    public function getProjects(): array
    {
        return $this->projects;
    }

    public function getUsers(): array
    {
        return $this->users;
    }

    public function getTasks(): array
    {
        return $this->tasks;
    }

    public function getSubtasks(): array
    {
        return $this->subtasks;
    }

    public function getSecondsFor($entity): int
    {
        if ($entity instanceof Organization) {
            return $this->getSecondsForOrganization($entity);
        }
        if ($entity instanceof Project) {
            return $this->getSecondsForProject($entity);
        }
        if ($entity instanceof Task) {
            return $this->getSecondsForTask($entity);
        }

        throw new \InvalidArgumentException('Invalid entity type');
    }

    public function getSecondsForTask(?Task $task = null): int
    {
        $taskId = $task ? $task->getId() : 0;
        foreach ($this->tasks as $taskData) {
            if ($taskData['id'] === $taskId) {
                return $taskData['seconds'];
            }
        }

        return 0;
    }

    public function getSecondsForOrganization(?Organization $organization = null): int
    {
        $organizationId = $organization ? $organization->getId() : 0;
        foreach ($this->organizations as $organizationData) {
            if ($organizationData['id'] === $organizationId) {
                return $organizationData['seconds'];
            }
        }

        return 0;
    }

    public function getSecondsForProject(?Project $project = null): int
    {
        $projectId = $project ? $project->getId() : 0;
        foreach ($this->projects as $projectData) {
            if ($projectData['id'] === $projectId) {
                return $projectData['seconds'];
            }
        }

        return 0;
    }
}
