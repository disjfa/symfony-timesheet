<?php

namespace App\Entity;

use App\Repository\TimeEntryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TimeEntryRepository::class)]
#[ORM\HasLifecycleCallbacks]
class TimeEntry
{
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $start_date = null;

    #[ORM\Column]
    private ?int $seconds = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $note = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'time_entries')]
    public User $user;

    #[ORM\ManyToOne(targetEntity: Project::class, inversedBy: 'time_entries')]
    public Project $project;

    #[ORM\ManyToOne(targetEntity: Task::class, inversedBy: 'time_entries')]
    public Task $task;

    #[ORM\ManyToOne(targetEntity: Subtask::class, inversedBy: 'time_entries')]
    public Subtask $subtask;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): static
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getSeconds(): ?int
    {
        return $this->seconds;
    }

    public function setSeconds(int $seconds): static
    {
        $this->seconds = $seconds;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getProject(): Project
    {
        return $this->project;
    }

    public function setProject(Project $project): void
    {
        $this->project = $project;
    }

    public function getTask(): Task
    {
        return $this->task;
    }

    public function setTask(Task $task): void
    {
        $this->task = $task;
    }

    public function getSubtask(): Subtask
    {
        return $this->subtask;
    }

    public function setSubtask(Subtask $subtask): void
    {
        $this->subtask = $subtask;
    }

    public function getEndDate(): \DateTimeInterface
    {
        $endDate = clone $this->start_date;
        $endDate->modify(sprintf('+%d seconds', $this->seconds));

        return $endDate;
    }
}
