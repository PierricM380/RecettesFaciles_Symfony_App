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

        for ($l = 0; $l < 2; $l += 1) {
            $user = new User();
            $user
                ->setFullName($this->faker->name())
                ->setPseudo(mt_rand(0, 1) === 1 ? $this->faker->firstName() : null)
                ->setEmail($this->faker->email())
                ->setRoles(['ROLE_USER'])
                ->setPlainPassword('password');

            $users[] = $user;
            $manager->persist($user);
        }

        // Ingredients
        $ingredients = [];

        for ($i = 1; $i <= 5; $i += 1) {
            $ingredient = new Ingredient();

            $ingredient
                ->setName($this->faker->word());

            $ingredients[] = $ingredient;
            $manager->persist($ingredient);
        }

        // Recipes
        $recipes = [];

        for ($j = 0; $j < 10; $j++) {
            $recipe = new Recipe();
            $recipe
                ->setName($this->faker->word())
                ->setCategory($this->faker->word())
                ->setTime(mt_rand(0, 1) == 1 ? mt_rand(1, 1440) : null)
                ->setDescription($this->faker->text(300));

            for ($k = 0; $k < mt_rand(5, 15); $k++) {
                $recipe->addIngredient($ingredients[mt_rand(0, count($ingredients) - 1)]);
            }

            $recipes[] = $recipe;
            $manager->persist($recipe);
        }

        $manager->flush();
    }
}
