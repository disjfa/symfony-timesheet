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

        for ($i = 1; $i <= 1337; ++$i) {
            $dateTime = new \DateTime();

            $dateTime->modify('next sunday');
            $dateTime->setTime(8, 0, 0);
            $dateTime->modify('-'.random_int(1, 12).' week');
            $dateTime->modify('+'.random_int(1, 5).' day');
            $dateTime->modify('+'.random_int(1, 8).' hour');

            shuffle($users);
            shuffle($subtasks);
            /** @var Subtask $subtask */
            $subtask = current($subtasks);
            $task = $subtask->getTask();
            $project = $task->getProject();

            $timeEntry = new TimeEntry();
            $timeEntry->setStartDate($dateTime);
            $timeEntry->setSeconds(random_int(1, 18) * 15 * 60);
            $timeEntry->setProject($project);
            $timeEntry->setTask($task);
            $timeEntry->setSubtask($subtask);
            $timeEntry->setUser(current($users));
            $manager->persist($timeEntry);
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
