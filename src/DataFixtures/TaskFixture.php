<?php

namespace App\DataFixtures;

use App\Entity\Project;
use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Random\RandomException;

class TaskFixture extends Fixture implements DependentFixtureInterface
{
    private array $tasks = [
        'Set up local development environment',
        'Initialize Git repository',
        'Configure database',
        'Create user authentication system',
        'Design homepage layout',
        'Implement REST API',
        'Optimize site performance',
        'Handle form validations',
        'Set up error logging',
        'Deploy application to production',
        'Write unit tests',
        'Integrate third-party APIs',
        'Create admin dashboard',
        'Develop user profile pages',
        'Configure caching system',
        'Implement role-based access control',
        'Set up automated backups',
        'Build a notification system',
        'Write technical documentation',
        'Create reusable components',
        'Setup continuous integration',
        'Optimize database queries',
        'Develop search functionality',
        'Configure session management',
        'Improve security measures',
        'Implement file uploads',
        'Ensure mobile responsiveness',
        'Fix UI/UX issues',
        'Create error pages',
        'Implement password reset',
        'Integrate payment gateway',
        'Manage dependencies',
        'Set up cron jobs',
        'Develop chat system',
        'Implement localization',
        'Optimize images',
        'Improve page loading speed',
        'Handle route management',
        'Create API documentation',
        'Monitor server performance',
        'Automate deployments',
        'Setup SSL certificate',
        'Implement dark mode',
        'Handle pagination',
        'Integrate OAuth authentication',
        'Develop reporting system',
        'Write clean code',
        'Implement two-factor authentication',
        'Configure Docker environment',
        'Build analytics dashboard',
        'Refactor legacy code',
        'Implement drag-and-drop features',
        'Create automated tests',
        'Develop CRUD operations',
        'Handle session expiration',
        'Improve accessibility features',
        'Implement websocket connections',
        'Set up logging and monitoring',
        'Develop recommendation engine',
        'Create a sitemap',
        'Optimize CSS and JavaScript',
        'Implement lazy loading',
        'Develop AI-powered features',
        'Setup CDN for assets',
        'Implement code linting',
        'Handle multi-tenancy',
        'Integrate real-time updates',
        'Implement infinite scrolling',
        'Optimize caching strategies',
        'Configure load balancing',
        'Setup secure headers',
        'Develop subscription system',
        'Create image processing pipeline',
        'Implement auto-save functionality',
        'Integrate blockchain features',
        'Develop gamification features',
        'Improve error handling',
        'Create plugin system',
        'Manage API rate limiting',
        'Implement data encryption',
        'Ensure cross-browser compatibility',
        'Setup cloud storage integration',
        'Develop recommendation system',
        'Write API tests',
        'Implement AI chatbots',
        'Setup automated email system',
        'Build a marketplace feature',
        'Create interactive charts',
        'Develop dynamic forms',
        'Optimize database indexing',
        'Implement social media login',
        'Handle database migrations',
        'Develop real-time notifications',
        'Improve typography',
        'Integrate voice recognition',
        'Ensure GDPR compliance',
        'Develop machine learning features',
        'Handle large file uploads',
        'Improve documentation structure',
        'Implement feedback system',
        'Develop offline functionality',
        'Create multi-step forms',
    ];

    /**
     * @throws RandomException
     */
    public function load(ObjectManager $manager): void
    {
        $projects = $manager->getRepository(Project::class)->findAll();

        for ($i = 0; $i < 2; ++$i) {
            foreach ($this->tasks as $taskName) {
                shuffle($projects);

                $task = new Task();
                $task->setName($taskName);
                $task->setProject(current($projects));
                $task->setEstimate(random_int(1, 32) * 60 * 60);
                $manager->persist($task);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ProjectFixtures::class,
        ];
    }
}
