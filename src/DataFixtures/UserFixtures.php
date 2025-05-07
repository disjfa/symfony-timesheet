<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    private array $emails = [
        'quantum.squirrel@fictionalmail.com',
        'bigfoot.marketing@cryptidmail.net',
        'organized.chaos@chaosmail.org',
        'intergalactic.alpaca@spaceemail.com',
        'cosmic.penguin@galaxymail.net',
        'ninja.banana@fruitforce.com',
        'dancing.potato@veggienet.org',
        'rainbow.unicorn@mythmail.com',
        'pixel.wizard@digitalrealm.dev',
        'time.traveling.toast@futuremail.io',
        'dragon.coffee@mysterybean.com',
        'quantum.kitten@catverse.net',
        'robot.gardener@techplants.org',
        'space.cookie@snackmail.com',
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
