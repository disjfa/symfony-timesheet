<?php

namespace App\DataFixtures;

use App\Entity\Subtask;
use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SubtaskFixture extends Fixture implements DependentFixtureInterface
{
    private array $subtasks = [
        'Install PHP and required extensions',
        'Set up a MySQL database',
        'Configure PHP.ini settings',
        'Initialize a Composer project',
        'Set up environment variables',
        'Write database schema migration scripts',
        'Develop user registration functionality',
        'Hash passwords securely',
        'Implement OAuth authentication',
        'Validate email addresses',
        'Create a user session handler',
        'Design a mobile-responsive homepage',
        'Optimize images for performance',
        'Implement lazy loading for assets',
        'Create RESTful API endpoints',
        'Write API request validation rules',
        'Enable CORS for cross-domain requests',
        'Develop unit tests for API endpoints',
        'Configure logging for API errors',
        'Optimize database queries for performance',
        'Set up a caching mechanism',
        'Implement role-based access control',
        'Develop an admin dashboard layout',
        'Integrate third-party analytics tools',
        'Implement a search functionality',
        'Index database tables for fast querying',
        'Develop pagination for large datasets',
        'Write custom error handlers',
        'Create 404 and 500 error pages',
        'Develop a notification system',
        'Integrate a payment gateway',
        'Handle asynchronous transactions',
        'Implement password reset with token validation',
        'Schedule automated backups',
        'Develop a file upload functionality',
        'Sanitize uploaded files for security',
        'Write documentation for API usage',
        'Create a multi-step form',
        'Develop CRUD operations for user management',
        'Optimize CSS and JavaScript delivery',
        'Implement content security policies',
        'Configure automated deployment scripts',
        'Set up Docker containers',
        'Configure SSL for secure communication',
        'Implement dark mode toggle',
        'Develop a live chat system using WebSockets',
        'Write integration tests for features',
        'Create an AI-powered recommendation engine',
        'Ensure GDPR compliance for data handling',
        'Monitor server performance and resource usage',
    ];

    public function load(ObjectManager $manager): void
    {
        $tasks = $manager->getRepository(Task::class)->findAll();

        for ($i = 0; $i < 10; ++$i) {
            foreach ($this->subtasks as $name) {
                shuffle($tasks);

                $subtask = new Subtask();
                $subtask->setName($name);
                $subtask->setTask(current($tasks));
                $manager->persist($subtask);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            TaskFixture::class,
        ];
    }
}
