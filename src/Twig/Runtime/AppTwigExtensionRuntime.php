<?php

namespace App\Twig\Runtime;

use App\Repository\CategoryRepository;
use Twig\Extension\RuntimeExtensionInterface;

class AppTwigExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct(
        private CategoryRepository $categoryRepository
    ) {}

    public function getCategories(): array
    {
        return [
            ['name' => 'Makeup', 'route' => 'shop_makeup'],
            ['name' => 'Lunettes', 'route' => 'shop_sunglasses'],
            ['name' => 'Montres', 'route' => 'shop_watches'],
            ['name' => 'Odyssey 25', 'route' => 'shop_odyssey'],
        ];
    }

    public function formatPrice(float $price): string
    {
        return '€ ' . number_format($price, 2, '.', ' ');
    }
}
