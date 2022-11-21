<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Faker\Generator;
use App\Entity\Recipe;
use App\Entity\Ingredient;
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
        // Users
        $users = [];

        $user = new User();
            $user
                ->setFullName("Ghislaine Marye")
                ->setPseudo("Gigi66380")
                ->setEmail("ghislaine.marye@gmail.com")
                ->setRoles(['ROLE_USER'])
                ->setPlainPassword('!PGEL?66380');

            $users[] = $user;
            $manager->persist($user);
    }
}
