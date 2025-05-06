<?php

namespace App\DataFixtures;

use App\Entity\Organization;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OrganizationFixtures extends Fixture
{
    private array $organizations = [
        'The League of Overcaffeinated Thinkers',
        'Quantum Squirrel Innovations',
        'Duck & Cover Consulting',
        'Unicorn Bureaucracy',
        'The Department of Organized Chaos',
        'Bigfoot Marketing Group',
        'Intergalactic Alpaca Syndicate',
        'The Ministry of Mildly Interesting Things',
        'Waffle Logistics',
        'The Society of Dubious Inventions',
    ];

    public function load(ObjectManager $manager): void
    {
        foreach ($this->organizations as $organizationName) {
            $organization = new Organization();
            $organization->setName($organizationName);
            $manager->persist($organization);
        }

        $manager->flush();
    }
}
