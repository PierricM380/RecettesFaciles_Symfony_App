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


    public function load(ObjectManager $manager): void
    {
        // User
        $user = new User();
        $user
            ->setFullName("Ghislaine Marye")
            ->setPseudo("Gigi66380")
            ->setEmail("ghislaine.marye@gmail.com")
            ->setRoles(['ROLE_USER'])
            ->setPlainPassword('!PGEL?66380');

        $manager->persist($user);
        $manager->flush();
    }
}
