<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/category')]
final class AdminCategoryController extends AbstractController
{
    #[Route('', name: 'admin_category_index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('admin/admin_category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/{id}', name: 'admin_category_show')]
    public function show(CategoryRepository $categoryRepository, int $id): Response
    {
        $category = $categoryRepository->find($id);

        return $this->render('admin/admin_category/show.html.twig', [
            'category' => $category,
        ]);
    }

    #[Route('/add/{name}', name: 'admin_category_add')]
    public function add(EntityManagerInterface $entityManager, string $name): Response
    {
        $category = new Category();
        $category->setName($name);

        $entityManager->persist($category);
        $entityManager->flush();

        return $this->redirectToRoute('admin_category_index');
    }

    #[Route('/{id}/{label}', name: 'admin_category_edit')]
    public function edit(CategoryRepository $categoryRepository, EntityManagerInterface $entityManager, int $id, string $label): Response
    {
        $category = $categoryRepository->find($id);

        if (!$category) {
            return new Response("Catégorie non trouvée", 404);
        }

        $category->setName($label);
        $entityManager->flush();

        return $this->redirectToRoute('admin_category_index');
    }

    #[Route('/delete/{id}', name: 'admin_category_delete')]
    public function delete(CategoryRepository $categoryRepository, EntityManagerInterface $entityManager, int $id): Response
    {
        $category = $categoryRepository->find($id);

        if (!$category) {
            return new Response("Catégorie non trouvée", 404);
        }

        $entityManager->remove($category);
        $entityManager->flush();

        return $this->redirectToRoute('admin_category_index');
    }
}
