<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Project
{
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: TimeEntry::class, mappedBy: 'project')]
    public Collection $timeEntries;

    #[ORM\ManyToOne(targetEntity: Organization::class, inversedBy: 'projects')]
    public Organization $organization;

    #[ORM\OneToMany(targetEntity: Task::class, mappedBy: 'project')]
    public Collection $tasks;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getTimeEntries(): Collection
    {
        return $this->timeEntries;
    }

    public function setTimeEntries(Collection $timeEntries): void
    {
        $this->timeEntries = $timeEntries;
    }

    public function getOrganization(): Organization
    {
        return $this->organization;
    }

    public function setOrganization(Organization $organization): void
    {
        $this->organization = $organization;
    }

    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function setTasks(Collection $tasks): void
    {
        $this->tasks = $tasks;
    }

    public function getTotalEstimate(): int
    {
        return $this->tasks->reduce(function ($carry, Task $task) {
            return $carry + $task->getEstimate();
        }, 0);
    }

    public function getTotalEntries(): int
    {
        return $this->timeEntries->reduce(function ($carry, TimeEntry $timeEntry) {
            return $carry + $timeEntry->getSeconds();
        }, 0);
    }
}
