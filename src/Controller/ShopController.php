<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/shop')]
final class ShopController extends AbstractController
{
    #[Route('', name: 'shop_index')]
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();

        $formattedProducts = array_map(function ($product) {
            return [
                'title' => $product->getTitle(),
                'cover' => $product->getCover(),
                'priceHT' => '€' . number_format($product->getPriceHT(), 2, ',', ' '),
                'priceTTC' => '€' . number_format($product->getPriceHT() * 1.2, 2, ',', ' '),
            ];
        }, $products);

        return $this->render('shop/index.html.twig', [
            'products' => $formattedProducts
        ]);
    }
}