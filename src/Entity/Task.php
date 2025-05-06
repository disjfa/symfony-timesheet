<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Task
{
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?int $estimate = null;

    #[ORM\ManyToOne(targetEntity: Project::class, inversedBy: 'tasks')]
    public Project $project;

    #[ORM\OneToMany(targetEntity: Subtask::class, mappedBy: 'task')]
    public Collection $subtasks;

    #[ORM\OneToMany(targetEntity: TimeEntry::class, mappedBy: 'task')]
    public Collection $timeEntries;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getEstimate(): ?int
    {
        return $this->estimate;
    }

    public function setEstimate(?int $estimate): static
    {
        $this->estimate = $estimate;

        return $this;
    }

    public function getProject(): Project
    {
        return $this->project;
    }

    public function setProject(Project $project): static
    {
        $this->project = $project;

        return $this;
    }

    public function getSubtasks(): Collection
    {
        return $this->subtasks;
    }

    public function setSubtasks(Collection $subtasks): static
    {
        $this->subtasks = $subtasks;

        return $this;
    }

    public function getTotalEstimate(): int
    {
        return $this->estimate;
    }

    public function getTotalEntries()
    {
        return $this->timeEntries->reduce(function ($carry, TimeEntry $timeEntry) {
            return $carry + $timeEntry->getSeconds();
        }, 0);
    }
}
