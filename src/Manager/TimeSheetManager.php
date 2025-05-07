<?php

namespace App\Manager;

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
                    'name' => $organization->getName(),
                    'color' => $organization->getColor(),
                    'seconds' => 0,
                ];
            }
            $this->organizations[$organization->getId()]['seconds'] += $timeEntry->getSeconds();

            if (!isset($this->projects[$project->getId()])) {
                $this->projects[$project->getId()] = [
                    'name' => $project->getName(),
                    'color' => $project->getColor(),
                    'seconds' => 0,
                ];
            }
            $this->projects[$project->getId()]['seconds'] += $timeEntry->getSeconds();

            if (!isset($this->users[$user->getId()])) {
                $this->users[$user->getId()] = [
                    'name' => $user->getEmail(),
                    'seconds' => 0,
                ];
            }
            $this->users[$user->getId()]['seconds'] += $timeEntry->getSeconds();

            if (!isset($this->tasks[$task->getId()])) {
                $this->tasks[$task->getId()] = [
                    'name' => $task->getName(),
                    'seconds' => 0,
                ];
            }
            $this->tasks[$task->getId()]['seconds'] += $timeEntry->getSeconds();
        }

        usort($this->organizations, static function ($a, $b) {
            return strcmp($a['name'], $b['name']);
        });
        usort($this->projects, static function ($a, $b) {
            return strcmp($a['name'], $b['name']);
        });
        usort($this->users, static function ($a, $b) {
            return strcmp($a['name'], $b['name']);
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
}
