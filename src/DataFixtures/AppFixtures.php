<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Faker\Generator;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class AppFixtures extends Fixture
{
    /**
     * @var Generator
     */
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

/**
 * Load user
 *
 * @param ObjectManager $manager
 * @return void
 */
    public function load(ObjectManager $manager): void
    {
        // User
        $user = new User();
        $user
            ->setFullName("Prénom Nom")
            ->setPseudo("Pseudo")
            ->setEmail("example@example.fr")
            ->setRoles(['ROLE_USER'])
            ->setPlainPassword('Password');

        $manager->persist($user);
        $manager->flush();
    }
}
