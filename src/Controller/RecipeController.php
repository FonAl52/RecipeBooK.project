<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;

class RecipeController extends AbstractController
{
    /**
     * This controller display all recipes
     *
     * @param RecipeRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/recette', name: 'recipe.index', methods: ['GET'])]
    public function index(
        RecipeRepository $repository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $recipes = $paginator->paginate(
            $repository->findBy(['user' => $this->getUser()]),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('pages/recipe/index.html.twig', [
            'recipes' => $recipes,
        ]);
    }

    /**
     * This controller allow us to create a new recipe
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/recette/creation', 'recipe.new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $recipe = $form->getData();
            $recipe->setUser($this->getUser());

            $manager->persist($recipe);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre recette a été créé avec succès !'
            );

            return $this->redirectToRoute('recipe.index');
        }

        return $this->render('pages/recipe/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * This controller allow us to edit a recipe
     *
     * @param Recipe $recipe
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Security("is_granted('ROLE_USER') and user === recipe.getUser()")]
    #[Route('/recette/edition/{id}', 'recipe.edit', methods: ['GET', 'POST'])]
    public function edit(
        Recipe $recipe,
        Request $request,
        EntityManagerInterface $manager
    ): Response {
        $isUserAllowed = $this->getUser() == $recipe->getUser();

        if ($isUserAllowed) {
            $this->denyAccessUnlessGranted('ROLE_USER');

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

        return $this->redirectToRoute('security.login');
    }

    /**
     * This controller allow us to delete a recipe
     *
     * @param EntityManagerInterface $manager
     * @param Recipe $recipe
     * @return Response
     */
    #[Route('/recette/suppression/{id}', 'recipe.delete', methods: ['GET'])]
    public function delete(
        EntityManagerInterface $manager,
        Recipe $recipe
    ): Response {
        $isUserAllowed = $this->getUser() == $recipe->getUser();

        if ($isUserAllowed) {
            $this->denyAccessUnlessGranted('ROLE_USER');

            $manager->remove($recipe);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre recette a été supprimé avec succès !'
            );

            return $this->redirectToRoute('recipe.index');
        } 

        return $this->redirectToRoute('security.login');
    }

}
