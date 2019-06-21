<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Astronaut;

class AstroFixtures extends Fixture
{
    // Executed on doctrine:fixture:load
    public function load(ObjectManager $manager)
    {
        // Create and persist a new Astronaut entity
        $astro = new Astronaut();

        $astro->setName("Arty");
        $astro->setAge(22);
        $astro->setPlanet("Duck Invaders");
        $astro->setScore(9000);

        $manager->persist($astro);

        $astro2 = new Astronaut();
        $astro2->setName("Bob");
        $astro2->setAge(45);
        $astro2->setPlanet("Schizo Cats");
        $astro2->setScore(45);
        $manager->persist($astro2);

        $astro3 = new Astronaut();
        $astro3->setName("George");
        $astro3->setAge(32);
        $astro3->setPlanet("Donut Factory");
        $astro3->setScore(163);
        $manager->persist($astro3);

        $manager->flush();
    }
}
