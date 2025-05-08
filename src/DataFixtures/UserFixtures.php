<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    private array $emails = [
        'quantum.squirrel@fictionalmail.com' => 'Oliver Anderson',
        'bigfoot.marketing@cryptidmail.net' => 'Emma Thompson',
        'organized.chaos@chaosmail.org' => 'Lucas Martinez',
        'intergalactic.alpaca@spaceemail.com' => 'Sophia Chen',
        'cosmic.penguin@galaxymail.net' => 'Jackson Williams',
        'ninja.banana@fruitforce.com' => 'Isabella Rodriguez',
        'dancing.potato@veggienet.org' => 'Ethan Parker',
        'rainbow.unicorn@mythmail.com' => 'Ava Johnson',
        'pixel.wizard@digitalrealm.dev' => 'Noah Garcia',
        'time.traveling.toast@futuremail.io' => 'Mia Wilson',
        'dragon.coffee@mysterybean.com' => 'William Lee',
        'quantum.kitten@catverse.net' => 'Charlotte Brown',
        'robot.gardener@techplants.org' => 'Benjamin Taylor',
        'space.cookie@snackmail.com' => 'Amelia Davis',
        'waffle.logistics@breakfastmail.com' => 'James Murphy',
    ];

    public function load(ObjectManager $manager): void
    {
        foreach ($this->emails as $email => $name) {
            $user = new User();
            $user->setEmail($email);
            $user->setName($name);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
