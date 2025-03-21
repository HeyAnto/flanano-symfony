<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\ProductFormType;
use App\Form\CategoryFormType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/product')]
final class AdminProductController extends AbstractController
{
    #[Route('', name: 'admin_product_index')]
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();

        return $this->render('admin/admin_product/index.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/{id}', name: 'admin_product_show')]
    public function show(ProductRepository $productRepository, int $id): Response
    {
        $product = $productRepository->find($id);

        return $this->render('admin/admin_product/show.html.twig', [
            'product' => $product,
        ]);
    }

    // #[Route('/add/category', name: 'admin_category_add')]
    // public function add(EntityManagerInterface $entityManager, Request $request): Response
    // {
    //     $category = new Category();

    //     $form = $this->createForm(CategoryFormType::class, $category, [
    //         'csrf_token_id' => 'edit_category_' . $category->getId(),
    //     ]);

    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->persist($category);
    //         $entityManager->flush();
    //         return $this->redirectToRoute('admin_category_index');
    //     }

    //     return $this->render('admin/admin_category/add.html.twig', [
    //         'form' => $form->createView(),
    //     ]);
    // }

    #[Route('/edit/product/{id}', name: 'admin_product_edit')]
    public function edit(int $id, ProductRepository $productRepository, EntityManagerInterface $entityManager, Request $request): Response
    {
        $product = $productRepository->find($id);

        if (!$product) {
            return new Response("Produit non trouvée", 404);
        }

        $form = $this->createForm(ProductFormType::class, $product, [
            'csrf_token_id' => 'edit_product_' . $product->getId(),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($product);
            $entityManager->flush();
            return $this->redirectToRoute('admin_product_index');
        }

        return $this->render('admin/admin_product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/delete/product/{id}', name: 'admin_product_delete')]
    public function delete(ProductRepository $productRepository, EntityManagerInterface $entityManager, int $id): Response
    {
        $product = $productRepository->find($id);

        if (!$product) {
            return new Response("Produit non trouvée", 404);
        }

        $entityManager->remove($product);
        $entityManager->flush();

        return $this->redirectToRoute('admin_product_index');
    }
}
