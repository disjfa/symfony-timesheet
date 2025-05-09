<?php

namespace App\DataFixtures;

use App\Entity\Subtask;
use App\Entity\TimeEntry;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Random\RandomException;

class TimeEntryFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @throws RandomException
     */
    public function load(ObjectManager $manager): void
    {
        $users = $manager->getRepository(User::class)->findAll();
        $subtasks = $manager->getRepository(Subtask::class)->findAll();

        foreach ($users as $user) {
            $day_free = random_int(0, 4);

            $dateTime = new \DateTime();
            $dateTime->modify('this monday');
            $dateTime->modify('-6 weeks');
            $dateTime->setTime(9, 0, 0);

            for ($week = 0; $week < 6; ++$week) {
                for ($day = 0; $day < 5; ++$day) {
                    if ($day_free !== $day) {
                        $remainingSeconds = 28800; // 8 hours in seconds
                        $currentTime = clone $dateTime;

                        while ($remainingSeconds > 0) {
                            shuffle($subtasks);
                            /** @var Subtask $subtask */
                            $subtask = current($subtasks);
                            $task = $subtask->getTask();
                            $project = $task->getProject();

                            $maxDuration = min($remainingSeconds, 4 * 60 * 60); // Max 4 hours per entry
                            $minDuration = 15 * 60; // 15 minutes in seconds
                            $fifteenMinutes = 15 * 60; // 15 minutes in seconds
                            $maxDurationLimit = 4 * 60 * 60; // 4 hours in seconds
                            $randomDuration = random_int($minDuration, min($maxDurationLimit, $maxDuration));
                            $duration = round($randomDuration / $fifteenMinutes) * $fifteenMinutes;

                            $timeEntry = new TimeEntry();
                            $timeEntry->setStartDate($currentTime);
                            $timeEntry->setSeconds($duration);
                            $timeEntry->setProject($project);
                            if (random_int(0, 100) < 70) {
                                $timeEntry->setTask($task);
                                if (random_int(0, 100) < 50) {
                                    $timeEntry->setSubtask($subtask);
                                }
                            }
                            $timeEntry->setUser($user);
                            $manager->persist($timeEntry);

                            $remainingSeconds -= $duration;
                            $currentTime = (clone $currentTime)->modify("+{$duration} seconds");
                        }
                    }
                    $dateTime->modify('+1 day');
                }
                $dateTime->modify('+2 days'); // Skip to next Monday
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            SubtaskFixture::class,
            UserFixtures::class,
        ];
    }
}
