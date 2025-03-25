<?php

namespace App\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;

class AppTwigExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct()
    {
        // Inject dependencies if needed
    }

    public function formatPrice(float $price): string
    {
        return '€ ' . number_format($price, 2, '.', ' ');
    }
}
