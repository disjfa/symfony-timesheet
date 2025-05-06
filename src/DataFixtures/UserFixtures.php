<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    private $emails = [
        'quantum.squirrel@fictionalmail.com',
        'bigfoot.marketing@cryptidmail.net',
        'organized.chaos@chaosmail.org',
        'intergalactic.alpaca@spaceemail.com',
        'waffle.logistics@breakfastmail.com',
    ];

    public function load(ObjectManager $manager): void
    {
        foreach ($this->emails as $email) {
            $user = new User();
            $user->setEmail($email);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
