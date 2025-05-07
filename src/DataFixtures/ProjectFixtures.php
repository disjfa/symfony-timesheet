<?php

namespace App\DataFixtures;

use App\Entity\Organization;
use App\Entity\Project;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Spatie\Color\Names;

class ProjectFixtures extends Fixture implements DependentFixtureInterface
{
    use Names;

    private array $projects = [
        '24-Hour Coffee Marathon',
        'World’s Strongest Espresso Challenge',
        'Theoretical Coffee Physics',
        'The Sleepless Hackathon',
        'Squirrel-Powered WiFi',
        'Quantum Acorn Storage',
        'Rocket Squirrel Project',
        'The Squirrel Surveillance System',
        'The Apocalypse Preparedness Handbook',
        'Bubble-Wrap Suit Initiative',
        'Executive Hide-and-Seek',
        'Boardroom Obstacle Course',
        'Magical Paperwork Optimization',
        'Unicorn-Based Productivity Metrics',
        'Department of Fantasy Integration',
        'The Unicorn Compliance Act',
        'The Controlled Explosion Experiment',
        'Office-wide Randomness Day',
        'The Productivity vs. Procrastination Debate',
        'Silent Disco Meetings',
        'The Ultimate Hide-and-Seek Championship',
        'Mystery Brand Campaign',
        '"Did You See That?" Initiative',
        'The Loch Ness Merchandising Plan',
        'Space Alpaca Training Program',
        'The Mars Alpaca Colony',
        'Astro-Alpaca Fashion Line',
        'The Galactic Grazing Study',
        'The Meh Museum',
        'World’s Most Average Fact Compilation',
        'The Almost Amazing Race',
        'The Slightly Enthusiastic Newsletter',
        'The 24/7 Waffle Delivery Service',
        'Waffle-Based Currency Initiative',
        'The Syrup Supply Chain Optimization',
        'Intercontinental Waffle Exchange',
        'The Self-Watering Umbrella',
        'Hoverboard Lawn Mower',
        'The AI-powered Spoon',
        'The Reverse Alarm Clock',
        'The No-Spill Coffee Cup',
        'The Silent Karaoke Machine',
        'The One-Handed Chopsticks',
        'The Pocket-sized Air Conditioner',
        'The Anti-Sneeze Mask',
        'The GPS-Enabled Socks',
        'The Edible Book Series',
        'The Solar-Powered Flashlight',
        'The Reverse Microwave',
        'The Adjustable Gravity Boots',
    ];

    public function load(ObjectManager $manager): void
    {
        $colorNames = array_keys($this->names);

        shuffle($this->projects);

        $organizations = $manager->getRepository(Organization::class)->findAll();

        foreach ($this->projects as $projectName) {
            shuffle($colorNames);
            shuffle($organizations);

            $project = new Project();
            $project->setName($projectName);
            $project->setOrganization(current($organizations));
            $project->setColor(current($colorNames));
            $manager->persist($project);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            OrganizationFixtures::class,
            UserFixtures::class,
        ];
    }
}
