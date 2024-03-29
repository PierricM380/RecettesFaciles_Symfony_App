<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Data\SearchRecipe;
use App\Form\SearchRecipeType;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecipeController extends AbstractController
{
    /**
     * Display list of all recipes and a searching specific recipe
     *
     * @param RecipeRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[IsGranted('ROLE_USER')]
    #[Route('/recette', name: 'recipe.index', methods: ['GET'])]
    public function index(RecipeRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $data = new SearchRecipe();
        $form = $this->createForm(SearchRecipeType::class, $data);
        $form->handleRequest($request);

        $recipes = $paginator->paginate(
            $repository->searchRecipe($data),
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('pages/recipe/index.html.twig', [
            'recipes' => $recipes,
            'searchRecipe' => $form->createView()
        ]);
    }

    /**
     * Display appetizer recipes
     *
     * @param RecipeRepository $repository
     * @return Response
     */
    #[Route('/recette/aperitifs', name: 'recipe.show.appetizer', methods: ['GET'])]
    public function showAppetizer(RecipeRepository $repository): Response
    {
        $appetizer = $repository->findBy(
            ['category' => 'apéritifs']
        );

        return $this->render('pages/recipe/showAppetizer.html.twig', [
            'recipes' => $appetizer
        ]);
    }

    /**
     * Display dish recipes
     *
     * @param RecipeRepository $repository
     * @return Response
     */
    #[Route('/recette/plats', name: 'recipe.show.dish', methods: ['GET'])]
    public function showdish(RecipeRepository $repository): Response
    {
        $dish = $repository->findBy(
            ['category' => 'plats']
        );

        return $this->render('pages/recipe/showDish.html.twig', [
            'recipes' => $dish
        ]);
    }

    /**
     * Display desserts recipes
     *
     * @param RecipeRepository $repository
     * @return Response
     */
    #[Route('/recette/desserts', name: 'recipe.show.dessert', methods: ['GET'])]
    public function showDessert(RecipeRepository $repository): Response
    {
        $dessert = $repository->findBy(
            ['category' => 'desserts']
        );

        return $this->render('pages/recipe/showDessert.html.twig', [
            'recipes' => $dessert
        ]);
    }

    /**
     * Create a recipe with form template
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[IsGranted('ROLE_USER')]
    #[Route('/recette/creation', name: 'recipe.new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recipe = $form->getData();

            $manager->persist($recipe);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre recette a été créée avec succès !'
            );

            return $this->redirectToRoute('recipe.index');
        }

        return $this->render('pages/recipe/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Edit recipe with form template
     *
     * @param Recipe $recipe
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Security("is_granted('ROLE_USER')")]
    #[Route('/recette/edition/{id}', 'recipe.edit', methods: ['GET', 'POST'])]
    public function edit(Recipe $recipe, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recipe = $form->getData();

            $manager->persist($recipe);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre recette a été modifié avec succès !'
            );

            return $this->redirectToRoute('recipe.index');
        }

        return $this->render('pages/recipe/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Delete selected recipe
     *
     * @param EntityManagerInterface $manager
     * @param Recipe $recipe
     * @return Response
     */
    #[Security("is_granted('ROLE_USER')")]
    #[Route('/recette/suppression/{id}', 'recipe.delete', methods: ['GET'])]
    public function delete(EntityManagerInterface $manager, Recipe $recipe): Response
    {
        $manager->remove($recipe);
        $manager->flush();

        $this->addFlash(
            'success',
            'Votre ingrédient a été supprimé avec succès !'
        );

        return $this->redirectToRoute('recipe.index');
    }
}
